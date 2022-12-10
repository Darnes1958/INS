<?php

namespace App\Http\Livewire\Buy;

use App\Models\buy\rep_buy_tran;
use App\Models\buy\buy_tran;
use App\Models\buy\buys;
use App\Models\jeha\jeha;
use App\Models\trans\trans;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;



class OrderBuyTableEdit extends Component
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

   protected $listeners = [
        'putdata','gotonext','ChkIfDataExist','HeadBtnClick','mounttable','GetOrderData'
    ];
   public function mounttable(){
       $this->mount();
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
     $res=rep_buy_tran::where('order_no',$this->order_no)->get();
     foreach ($res as $value)
        $this->orderdetail[] =
         ['item_no' => $value['item_no'], 'item_name' => $value['item_name'],
         'quant' => $value['quant'], 'price' => $value['price'],
         'subtot' => $value['sub_tot'],];

   }
   public function store(){

       if (count($this->orderdetail)==1){
           session()->flash('message', 'لم يتم ادخال اصناف بعد');

       }
      else {
          Config::set('database.connections.other.database', Auth::user()->company);

          DB::connection('other')->beginTransaction();

          try {
              DB::connection('other')->table('buys')->insert([
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
                  'tot_charges' => 0,
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

                  DB::connection('other')->table('buy_tran')->insert([
                      'order_no' => $this->order_no,
                      'item_no' => $item['item_no'],
                      'quant' => $item['quant'],
                      'price_input' => $item['price'],
                      'price' => $item['price'],
                      'emp' => Auth::user()->empno,
                      'tarjeeh' => 0

                  ]);
              }
              if ($this->madfooh != 0) {

                  $tran_no = trans::max('tran_no') + 1;
                  DB::connection('other')->table('trans')->insert([
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

              DB::connection('other')->commit();

              $this->emit('mounttable');
              $this->emit('dismountdetail');
              $this->emit('mounthead');


          } catch (\Exception $e) {
              DB::connection('other')->rollback();

              // something went wrong
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
            $this->tot1 = number_format(array_sum(array_column($this->orderdetail, 'subtot')),
                2, '.', '');
            $this->tot = number_format($this->tot1 - $this->ksm,
                2, '.', '');

    }
    public function removeitem($value)    {
            unset($this->orderdetail[$value]);
            array_values($this->orderdetail);
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
