<?php

namespace App\Http\Livewire\Sell;

use App\Models\sell\sells;
use App\Models\stores\items;
use App\Models\stores\store_exp;
use App\Models\stores\stores;
use App\Models\trans\trans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderSellTable extends Component
{
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
    public $PlaceType;
    public $rebh;
    public $HasRaseed=true;
    public $ToSal;
    public $ToSal_L;
    public $OrderChanged=false;

    protected $listeners = [
        'putdata','gotonext','ChkIfDataExist','HeadBtnClick','mounttable'
    ];
    public function mounttable(){
        $this->mount();
    }

    public function store(){
        $conn=Auth()->user()->company;
        if (count($this->orderdetail)==1){
            session()->flash('message', 'لم يتم ادخال اصناف بعد');
        }
        else {
            if (sells::on(auth()->user()->company)->where('order_no',$this->order_no)->exists())
            {$this->order_no=sells::on(auth()->user()->company)->max('order_no')+1;
               $this->OrderChanged=true;}
            $this->HasRaseed=true;
            DB::connection($conn)->beginTransaction();
            try {
              if ($this->ToSal) {
                $per_no=store_exp::on(Auth()->user()->company)->max('per_no')+1;
                for ($i = 0; $i < count($this->orderdetail); $i++) {
                  $item=$this->orderdetail[$i];
                  if ($item['item_no'] == 0) {   continue;    }
                  DB::connection(Auth()->user()->company)->table('store_exp')->insert([
                    'st_no'=>$this->st_no,
                    'per_no'=>$per_no,
                    'item_no' => $item['item_no'],
                    'quant' => $item['quant'],
                    'exp_date'=>$this->order_date,
                    'order_no'=>0,
                    'per_type'=>2,
                    'st_no2'=>0,
                    'hall_no'=>$this->ToSal_L,
                    'emp'=>Auth::user()->empno,
                  ]);
                }

                $this->PlaceType='Salat';
                $this->st_no=$this->ToSal_L;
              }

               if ($this->PlaceType=='Makazen') $pt=1; else $pt=2;
                DB::connection($conn)->table('sells')->insert([
                    'order_no' => $this->order_no,
                    'jeha' => $this->jeha_no,
                    'order_date' => $this->order_date,
                    'order_date_input' => date('Y-m-d'),
                    'notes' => $this->notes,
                    'price_type' => $this->price_type,
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
              $i=0;

              for ($i = 0; $i < count($this->orderdetail); $i++) {
                    $item=$this->orderdetail[$i];
                    if ($item['item_no'] == 0) {
                        continue;
                    }
                    if ($this->PlaceType=='Makazen')
                     {
                      $pt=1;
                      $st_quant=DB::connection($conn)->table('stores')
                        ->where('st_no', '=', $this->st_no)
                        ->where('item_no','=',$item['item_no'])
                        ->pluck('raseed');
                      $st_quant=(int)$st_quant[0];
                      $quant=(int)$item['quant'];

                      if ($quant>$st_quant)
                      {$this->dispatchBrowserEvent('mmsg', 'الصنف :'.$item['item_no'].' رصيده لا يكفي');
                       $this->HasRaseed=false;

                       break;
                      }
                     }

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
                        'tran_type' => $this->price_type,
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
                if ($this->OrderChanged){
                    $this->OrderChanged=false;
                    $this->dispatchBrowserEvent('mmsg', 'تم تغيير رقم الفاتورة وتخرينها بالرقم : '.$this->order_no);
                }
                $this->emit('mounttable');
                $this->emit('dismountdetail');
                $this->emit('mounthead');
              } else {DB::connection($conn)->rollback();}
            } catch (\Exception $e) {
              //info($e);
                DB::connection($conn)->rollback();
                $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
            }
        }
    }
    public function HeadBtnClick($Wor,$wd,$wjh,$wplace,$wst,$price_type,$ToSal,$ToSal_L)
    {
        $this->ToSal=$ToSal;
        $this->ToSal_L=$ToSal_L;
        $this->order_no=$Wor;
        $this->order_date=$wd;
        $this->jeha_no=$wjh;
        $this->st_no=$wst;
        $this->PlaceType=$wplace;
        $this->price_type=$price_type;
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
      $this->emitTo('sell.order-sell-detail','TakeNewItem');


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
        return view('livewire.sell.order-sell-table',$this->orderdetail);
    }
}
