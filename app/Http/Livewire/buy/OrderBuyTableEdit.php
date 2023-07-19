<?php

namespace App\Http\Livewire\Buy;

use App\Models\buy\charges_buy;
use App\Models\buy\rep_buy_tran;
use App\Models\buy\buy_tran;
use App\Models\buy\buys;
use App\Models\jeha\jeha;
use App\Models\Operations;
use App\Models\stores\items;
use App\Models\stores\stores;
use App\Models\trans\trans;
use Carbon\Carbon;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Http\Livewire\Traits\MyLib;


class OrderBuyTableEdit extends Component
{
   public $showtable=true;
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
   public $HasRaseed=true;
   public $TheDelete;
   public $ChargeDetail=[];
   public $ChargeTot;

   use MyLib;

   protected $listeners = [
        'putdata','gotonext','ChkIfDataExist','HeadBtnClick','mounttable',
       'GetOrderData','DoItemDelete','open','TakeChargeAll',
    ];
   public function mounttable(){
       $this->mount();
   }

  public function open($open){
    $this->showtable=$open;
  }
    public function TakeChargeAll($chargedetail,$tot){
        $this->ChargeDetail=$chargedetail;
        $this->ChargeTot=$tot;
    }

   public function GetOrderData($order_no,$ksm,$madfooh,$tot1,$tot,$jeha,$stno,$notes){
     $this->order_no=$order_no;
     $this->ksm=$ksm;
     $this->madfooh=$madfooh;
     $this->tot1=$tot1;
     $this->tot=$tot;
     $this->jeha_no=$jeha;
     $this->st_no=$stno;
     $this->notes=$notes;
     $res=rep_buy_tran::on(Auth()->user()->company)->where('order_no',$this->order_no)->get();
     foreach ($res as $value)
        $this->orderdetail[] =
         ['item_no' => $value['item_no'], 'item_name' => $value['item_name'],
         'quant' => $value['quant'], 'price' => $value['price_input'],
         'subtot' => $value['sub_tot'],];

   }
   public function store(){

       if (count($this->orderdetail)==1){
           session()->flash('message', 'لم يتم ادخال اصناف بعد');

       }
      else {
          DB::connection(Auth()->user()->company)->beginTransaction();

          try {

              buy_tran::on(Auth()->user()->company)->where('order_no',$this->order_no)->delete();
              buys::on(Auth()->user()->company)->where('order_no',$this->order_no)->delete();

              DB::connection(Auth()->user()->company)->table('buys')->insert([
                  'order_no' => $this->order_no,
                  'order_no2' => 0,
                  'jeha' => $this->jeha_no,
                  'order_date' => $this->order_date,
                  'order_date_input' => $this->order_date,
                  'notes' => $this->notes,
                  'price_type' => 1,
                  'tot1' => $this->tot1,
                  'ksm' => $this->ksm,
                  'tot' => $this->tot,
                  'tot_charges' => $this->ChargeTot,
                  'cash' => $this->madfooh,
                  'not_cash' => $this->tot - $this->madfooh,
                  'place_no' => $this->st_no,
                  'tran_no' => 0,
                  'emp' => Auth::user()->empno,
                  'available' => 0
              ]);

              foreach ($this->orderdetail as $item) {

                  if ($item['item_no'] == 0) {
                      continue;
                  }


                if ( $this->RetPlaceRaseed($item['item_no'],'Makazen',$this->st_no)+$item['quant']<0) {
                  $this->dispatchBrowserEvent('mmsg',
                    ' رصيد المخزن للصنف '.$item['item_no'].' .. سيصبح أقل من صفر ');
                  $this->HasRaseed=false;
                  break;}
                else $this->HasRaseed=True;

                  DB::connection(Auth()->user()->company)->table('buy_tran')->insert([
                      'order_no' => $this->order_no,
                      'item_no' => $item['item_no'],
                      'quant' => $item['quant'],
                      'price_input' => $item['price'],
                      'price' => $item['price'],
                      'emp' => Auth::user()->empno,
                      'tarjeeh' => 0


                  ]);
              }

              if ($this->madfooh != 0 && $this->HasRaseed) {

                  $tran_no = trans::on(Auth()->user()->company)->max('tran_no') + 1;
                  DB::connection(Auth()->user()->company)->table('trans')->insert([
                      'tran_no' => $tran_no,
                      'jeha' => $this->jeha_no,
                      'val' => $this->madfooh,
                      'tran_date' => $this->order_date,
                      'tran_type' => 1,
                      'imp_exp' => 2,
                      'tran_who' => 2,
                      'chk_no' => 0,
                      'notes' => 'فاتورة مشتريات ' . $this->order_no,
                      'kyde' => 0,
                      'emp' => Auth::user()->empno,
                      'order_no' => $this->order_no

                  ]);
              }
              if ($this->HasRaseed) {
                if ($this->ChargeTot!=0) {
                  foreach ($this->ChargeDetail as $item) {
                    if ($item['type_no'] == 0 || $item['type_name']='') {
                      continue;
                    }

                    charges_buy::on(Auth()->user()->company)->insert([
                      'order_no'=>$this->order_no,
                      'charge_type'=>$item['type_no'],
                      'charge_by' => $item['no'],
                      'val' => $item['val'],
                    ]);
                  }
                  $tot1=buy_tran::on(Auth::user()->company)->where('order_no',$this->order_no)->sum(DB::raw('quant * price_input'));
                  $sum_val=charges_buy::on(Auth::user()->company)->where('order_no',$this->order_no)->sum('val');
                  $items=buy_tran::on(Auth::user()->company)->where('order_no',$this->order_no)->get();
                  foreach ($items as $item){
                    $item_no=$item->item_no;
                    $sub_tot=$item->quant*$item->price_input;
                    $ratio=$sub_tot/$tot1*100;
                    $val=(($ratio/100*$sum_val)/$item->quant)+$item->price;
                    buy_tran::on(Auth::user()->company)->where('order_no',$this->order_no)->where('item_no',$item->item_no)->update([
                      'price'=>$val, ]);
                  }
                }

                $itemss=items::on(Auth::user()->company)->whereIn('item_no', function($q){
                  $q->select('item_no')->from('buy_tran')->where('order_no',$this->order_no);})->get();
                foreach ($itemss as $item) {
                  $buys = buys::on(Auth::user()->company)
                    ->join('buy_tran', 'buys.order_no', '=', 'buy_tran.order_no')
                    ->select('quant', 'price')
                    ->where('item_no', $item->item_no)
                    ->orderBy('order_date_input', 'desc')
                    ->get();
                  $calc_raseed = $item->raseed;
                  $tot = 0;
                  for ($i = 0; $i < count($buys); $i++) {
                    if ($calc_raseed > $buys[$i]->quant) {
                      $tot += $buys[$i]->quant * $buys[$i]->price;
                      $calc_raseed -= $buys[$i]->quant;
                    } else {
                      $tot += $calc_raseed * $buys[$i]->price;
                      break;
                    }
                  }
                 if (items::where('item_no', $item->item_no)->first()->raseed>0)
                  items::on(Auth::user()->company)->where('item_no', $item->item_no)
                    ->update(['price_cost' => $tot / $item->raseed]);
                }

              }

              if ($this->HasRaseed) {
                Operations::insert(['Proce'=>'مشتريات','Oper'=>'تعديل','no'=>$this->order_no,'created_at'=>Carbon::now(),'emp'=>auth::user()->empno,]);

                DB::connection(Auth()->user()->company)->commit();

                $this->emit('mounttable');
                $this->emit('dismountdetail');
                $this->emit('mounthead');
              } else {  DB::connection(Auth()->user()->company)->rollback();}


          } catch (\Exception $e) {
              DB::connection(Auth()->user()->company)->rollback();
          }

      }
   }
   public function HeadBtnClick($Wor,$wd,$wjh,$wst)
   {
        $this->order_no=$Wor;
        $this->order_date=$wd;
        $this->jeha_no=$wjh;
        $this->st_no=$wst;

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
        }
        else {
            $this->orderdetail[] =
                ['item_no' => $value['item_no'], 'item_name' => $value['item_name'],
                    'quant' => $value['quant'], 'price' => $value['price'],
                    'subtot' => number_format($value['price'] * $value['quant'], 2, '.', '')];
        }
            $this->tot1 = number_format(array_sum(array_column($this->orderdetail, 'subtot')),2, '.', '');
            $this->tot = number_format($this->tot1 - $this->ksm,2, '.', '');

    }
    public function removeitem($value,$item,$quant)    {
        $st_raseed=stores::where('st_no',$this->st_no)->where('item_no',$item)->first();
        if ($st_raseed && $quant>$st_raseed->raseed){
            $this->dispatchBrowserEvent('mmsg', 'الصنف رقم :  '.$item.'  سيصبح رصيده فالمخزن اقل من الصفر');
            return false;

        }
            $this->TheDelete=$value;
      $this->dispatchBrowserEvent('dodelete');
    }
    public function DoItemDelete(){

      unset($this->orderdetail[$this->TheDelete]);
      array_values($this->orderdetail);
      $this->tot1 = number_format(array_sum(array_column($this->orderdetail, 'subtot')),2, '.', '');
      $this->tot = number_format($this->tot1 - $this->ksm,2, '.', '');

      $this->emit('mountdetail');
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
        return view('livewire.buy.order-buy-table-edit',$this->orderdetail);
    }
}
