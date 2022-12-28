<?php

namespace App\Http\Livewire\Sell;

use App\Models\aksat\main;
use App\Models\sell\rep_sell_tran;
use App\Models\sell\sell_tran;
use App\Models\sell\sells;
use App\Models\stores\items;
use App\Models\stores\stores;
use App\Models\trans\trans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Http\Livewire\Traits\MyLib;

class OrderSellTableEdit extends Component
{
    use MyLib;
    public $ksm;
    public $madfooh;
    public $tot1;
    public $tot;
    public $orderdetail=[];
    public $order_no;
    public $order_date;
    public $jeha_no;
    public $st_no;
    public $notes;
    public $price_type;

    public $TablePlaceType;
    public $rebh;
    public $HasRaseed=true;

    protected $listeners = [
        'putdata','gotonext','ChkIfDataExist','mounttable','GetOrderData'
    ];
  public function GetOrderData($order_no,$order_date,$price_type,$ksm,$madfooh,$tot1,$tot,$jeha,$placetype,$stno,$notes){
    $this->order_no=$order_no;
    $this->order_date=$order_date;
    $this->price_type=$price_type;
    $this->ksm=$ksm;
    $this->madfooh=$madfooh;
    $this->tot1=$tot1;
    $this->tot=$tot;
    $this->jeha_no=$jeha;
    $this->TablePlaceType=$placetype;

    $this->st_no=$stno;
    $this->notes=$notes;
      $conn=Auth()->user()->company;
    $res=rep_sell_tran::on($conn)->where('order_no',$this->order_no)->get();
    foreach ($res as $value)
      $this->orderdetail[] =
       ['item_no' => $value['item_no'], 'item_name' => $value['item_name'],
        'quant' => $value['quant'], 'price' => $value['price'],
        'subtot' => number_format($value['price'] * $value['quant'], 2, '.', ''),
        'rebh'=>$value['rebh'],];

  }
    public function mounttable(){
        $this->mount();
    }

    public function store(){

        $conn=Auth()->user()->company;
      if (count($this->orderdetail)==1){
            session()->flash('message', 'لم يتم ادخال اصناف بعد');
            return false;
        }
      if ($this->price_type==2) {
          $res=main::on($conn)->where('order_no',$this->order_no)->first();
          if ($res) {$no=$res->no;$sul_pay=$res->sul_pay;} else $no=0;
          if ($no!=0 && ($this->tot - $this->madfooh)<$res->sul_pay){
            session()->flash('message', 'يجب أن لا تكون قيمة الفاتورة أصغر من المدفوع في العقد');
            return false;
          }

        }
            $this->HasRaseed=true;
            DB::connection($conn)->beginTransaction();

            try {
              sell_tran::on($conn)->where('order_no',$this->order_no)->delete();
              sells::on($conn)->where('order_no',$this->order_no)->delete();

              if ($no!=0){
                main::on($conn)->where('no',$no)->update([
                 'sul_tot'=>$this->tot,
                 'sul'=>$this->tot - $this->madfooh,
                 'dofa'=>$this->madfooh,
                 'raseed'=>$this->tot - $this->madfooh-$sul_pay,
                ]);
              }
               if ($this->TablePlaceType=='Makazen') $pt=1; else $pt=2;
                DB::connection($conn)->table('sells')->insert([
                    'order_no' => $this->order_no,
                    'jeha' => $this->jeha_no,
                    'order_date' => $this->order_date,
                    'order_date_input' => $this->order_date,
                    'notes' => $this->notes,
                    'price_type' => 2,
                    'tot1' => $this->tot1,
                    'ksm' => $this->ksm,
                    'tot' => $this->tot,
                    'tot_charges' => 0,
                    'cash' => $this->madfooh,
                    'not_cash' => $this->tot - $this->madfooh,
                    'sell_type'=>$pt,
                    'place_no' =>$this->st_no ,
                    'tran_no' => 0,
                    'rebh' =>$this->rebh,
                    'emp' => Auth::user()->empno,
                    'available' => 0
                ]);

                foreach ($this->orderdetail as $item) {
                    if ($item['item_no'] == 0) {
                        continue;
                    }

                    if ( $this->RetPlaceRaseed($item['item_no'],$this->TablePlaceType,$this->st_no)<(int)$item['quant']) {
                         $this->dispatchBrowserEvent('mmsg', 'الصنف :'.$item['item_no'].' رصيده لا يكفي');
                         $this->HasRaseed=false;
                         break;}
                    else $this->HasRaseed=True;

                    if ($this->HasRaseed)
                    {DB::connection($conn)->table('sell_tran')->insert([
                        'order_no' => $this->order_no,
                        'item_no' => $item['item_no'],
                        'quant' => $item['quant'],
                        'price' => $item['price'],
                        'rebh' => $item['rebh'],
                        'emp' => Auth::user()->empno,
                        'tarjeeh' => 0

                    ]);}
                }
                if ($this->HasRaseed && $this->madfooh != 0) {

                    $tran_no = trans::on($conn)->max('tran_no') + 1;
                    DB::connection($conn)->table('trans')->insert([
                        'tran_no' => $tran_no,
                        'jeha' => $this->jeha_no,
                        'val' => $this->madfooh,
                        'tran_date' => $this->order_date,
                        'tran_type' => 2,
                        'imp_exp' => 1,
                        'tran_who' => 3,
                        'chk_no' => 0,
                        'notes' => 'فاتورة مبيعات ' . $this->order_no,
                        'kyde' => 0,
                        'emp' => Auth::user()->empno,
                        'order_no' => $this->order_no

                    ]);
                }
              if ($this->HasRaseed)
              {
                DB::connection($conn)->commit();
                $this->emit('mounttable');
                $this->emit('dismountdetail');
                $this->emit('mounthead');
              } else {DB::connection($conn)->rollback();}

            } catch (\Exception $e) {
                DB::connection($conn)->rollback();
                $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
            }

    }

    public function ChkIfDataExist($witem_no){

        $One= array_column($this->orderdetail, 'item_no');
        $index = array_search( $witem_no, $One);
        if  ( $index ) {
            $this->emit('YesIsFound',$this->orderdetail[$index]['quant'],
                $this->orderdetail[$index]['price']);

        }

    }
    public function gotonext($value)
    {
        $this->ksm = number_format($this->ksm,2, '.', '');
        $this->madfooh = number_format($this->madfooh,2, '.', '');
    }
    protected function rules()
    {
        return [
            'ksm' => ['required','numeric','gte:0','lte:tot1'],
            'madfooh' =>   ['required','numeric','gte:0','lte:tot'],
        ];
    }
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function updatedKsm() {

        $this->tot = number_format($this->tot1-$this->ksm,
            2, '.', '');
    }

    public function putdata($value)
    {

        $One= array_column($this->orderdetail, 'item_no');
        $index = array_search( $value['item_no'], $One);
        if  ($index) {
            $this->orderdetail[$index]['item_no']=$value['item_no'];
            $this->orderdetail[$index]['item_name']=$value['item_name'];
            $this->orderdetail[$index]['price']=$value['price'];
            $this->orderdetail[$index]['quant']=$value['quant'];
            $this->orderdetail[$index]['subtot']=
                number_format($value['price']*$value['quant'], 2, '.', '');
            $this->orderdetail[$index]['rebh']=$value['rebh'];
        }
        else {
            $this->orderdetail[] =
                ['item_no' => $value['item_no'], 'item_name' => $value['item_name'],
                    'quant' => $value['quant'], 'price' => $value['price'],
                    'subtot' => number_format($value['price'] * $value['quant'], 2, '.', ''),
                    'rebh'=>$value['rebh'],];
        }
        $this->tot1 = number_format(array_sum(array_column($this->orderdetail, 'subtot')),
            2, '.', '');
        $this->tot = number_format($this->tot1 - $this->ksm,
            2, '.', '');
      $this->rebh = number_format(array_sum(array_column($this->orderdetail, 'rebh')),
        2, '.', '');
      $this->emitTo('sell.order-sell-detail-edit','TakeNewItem');


    }
    public function removeitem($value)    {
        unset($this->orderdetail[$value]);
        array_values($this->orderdetail);
        $this->emitTo('sell.order-sell-detail','ClearData');
      $this->emitTo('sell.order-sell-detail','ClearData');
      $this->emitTo('sell.order-sell-detail','gotonext','item_no');
    }
    public function edititem($value)
    {
        $this->emit( 'edititem',$this->orderdetail[$value]) ;
    }
    public function mount()
    {

        $this->orderdetail=[
            ['item_no'=>'0','item_name'=>'',
                'quant'=>'0','price'=>'0',
                'subtot'=>'0']
        ];

        $this->ksm=number_format(0, 2, '.', '');
        $this->madfooh=number_format(0, 2, '.', '');
        $this->tot1=number_format(0, 2, '.', '');
        $this->tot=number_format(0, 2, '.', '');
        $this->notes=' ';

    }

    public function render()
    {
        return view('livewire.sell.order-sell-table-edit',$this->orderdetail);
    }
}
