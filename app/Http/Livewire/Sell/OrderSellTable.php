<?php

namespace App\Http\Livewire\Sell;

use App\Models\Arc\Arc_rep_sell_tran;
use App\Models\Arc\Arc_Sells;
use App\Models\Customers;
use App\Models\jeha\jeha;
use App\Models\sell\price_type;
use App\Models\sell\rep_sell_tran;
use App\Models\sell\sells;
use App\Models\stores\halls;
use App\Models\stores\halls_names;
use App\Models\stores\items;
use App\Models\stores\store_exp;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use App\Models\trans\trans;
use ArPHP\I18N\Arabic;
use Barryvdh\DomPDF\Facade\Pdf;
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
    public $printOrder=true;

    public $IsSave=false;

    protected $listeners = [
        'putdata','gotonext','ChkIfDataExist','HeadBtnClick','mounttable'
    ];
    public function mounttable(){
        $this->mount();
    }



  public function store(){
        if ($this->IsSave) return;
        $this->OrderChanged=false;
        if (count($this->orderdetail)==1){
            session()->flash('message', 'لم يتم ادخال اصناف بعد');
        }
        else {
            if (sells::where('order_no',$this->order_no)->exists())
            {$this->order_no=sells::on(auth()->user()->company)->max('order_no')+1;
               $this->OrderChanged=true;}
            $this->HasRaseed=true;
            DB::connection(Auth()->user()->company)->beginTransaction();
            try {

              if ($this->ToSal && $this->PlaceType=='Makazen') {
                  $per_no = store_exp::max('per_no') + 1;
                  for ($i = 0; $i < count($this->orderdetail); $i++) {

                      $item = $this->orderdetail[$i];


                      if ($item['item_no'] == 0) {
                          continue;
                      }
                      DB::connection(Auth()->user()->company)->table('store_exp')->insert([
                          'st_no' => $this->st_no,
                          'per_no' => $per_no,
                          'item_no' => $item['item_no'],
                          'quant' => $item['quant'],
                          'exp_date' => $this->order_date,
                          'order_no' => 0,
                          'per_type' => 2,
                          'st_no2' => 0,
                          'hall_no' => $this->ToSal_L,
                          'emp' => Auth::user()->empno,
                      ]);

                      $from = stores::where('st_no', $this->st_no)->where('item_no', $item['item_no'])->first();
                      $to = halls::where('hall_no', $this->ToSal_L)->where('item_no', $item['item_no'])->first();
                      if (!$to) {
                          halls::insert(['hall_no' => $this->ToSal_L, 'item_no' => $item['item_no'], 'raseed' => 0]);
                          $to = halls::where('hall_no', $this->ToSal_L)->where('item_no', $item['item_no'])->first();
                      }



                      $from->raseed -= $item['quant'];
                      $from->save();
                      $to->raseed += $item['quant'];
                      $to->save();


                  }
                  $this->PlaceType = 'Salat';
                  $this->st_no = $this->ToSal_L;
              }


               if ($this->PlaceType=='Makazen') $pt=1; else $pt=2;
                DB::connection(Auth()->user()->company)->table('sells')->insert([
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
                      $st_quant=DB::connection(Auth()->user()->company)->table('stores')
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
                  if ($this->PlaceType=='Salat')
                  {
                      $pt=2;
                      $st_quant=DB::connection(Auth()->user()->company)->table('halls')
                          ->where('hall_no', '=', $this->st_no)
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
                    {DB::connection(Auth()->user()->company)->table('sell_tran')->insert([
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
                    $tran_no = trans::on(Auth()->user()->company)->max('tran_no') + 1;
                    DB::connection(Auth()->user()->company)->table('trans')->insert([
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
                DB::connection(Auth()->user()->company)->commit();
                if ($this->OrderChanged){
                    $this->OrderChanged=false;
                    $this->dispatchBrowserEvent('mmsg', 'تم تغيير رقم الفاتورة وتخرينها بالرقم : '.$this->order_no);
                }
                $this->IsSave=true;
                $this->emit('mounttable');
                $this->emit('dismountdetail');
                $this->emit('mounthead');

                if ($this->printOrder) {
                    $res=sells::where('order_no',$this->order_no)->first();
                    $cus=Customers::where('Company',Auth::user()->company)->first();
                    $jeha_name=jeha::find($this->jeha_no)->jeha_name;
                    if ($res->sell_type==1){ $place_name=stores_names::find($res->place_no)->st_name;}
                    if ($res->sell_type==2){ $place_name=halls_names::find($res->place_no)->hall_name;}

                    $type_name=price_type::find($res->price_type)->type_name;

                    $orderdetail = rep_sell_tran::where('order_no', $this->order_no)->get();

                    $reportHtml = view('PrnView.sell.rep-order-sell',
                        ['orderdetail'=>$orderdetail,'res'=>$res,'cus'=>$cus,'jeha_name'=>$jeha_name,'place_name'=>$place_name,'type_name'=>$type_name])->render();
                    $arabic = new Arabic();
                    $p = $arabic->arIdentify($reportHtml);

                    for ($i = count($p)-1; $i >= 0; $i-=2) {
                        $utf8ar = $arabic->utf8Glyphs(substr($reportHtml, $p[$i-1], $p[$i] - $p[$i-1]));
                        $reportHtml = substr_replace($reportHtml, $utf8ar, $p[$i-1], $p[$i] - $p[$i-1]);
                    }
                    $pdf = PDF::loadHTML($reportHtml);

                    return response()->streamDownload(function () use($pdf) {
                        echo  $pdf->stream();
                    }, 'report.pdf');



                }

              } else {DB::connection(Auth()->user()->company)->rollback();}
            } catch (\Exception $e) {
              info($e);
                DB::connection(Auth()->user()->company)->rollback();
                $this->dispatchBrowserEvent('mmsg', 'حدث خطأ');
            }
        }
    }
    public function HeadBtnClick($Wor,$wd,$wjh,$wplace,$wst,$price_type,$ToSal,$ToSal_L)
    {
        $this->IsSave=false;
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
        $this->tot1 = number_format(array_sum(array_column($this->orderdetail, 'subtot')),2, '.', '');
        $this->tot = number_format($this->tot1 - $this->ksm,2, '.', '');
        $this->rebh = number_format(array_sum(array_column($this->orderdetail, 'rebh')),2, '.', '');
      $this->emitTo('sell.order-sell-detail','TakeNewItem');


    }
    public function removeitem($value)    {
        unset($this->orderdetail[$value]);
        array_values($this->orderdetail);
      $this->tot1 = number_format(array_sum(array_column($this->orderdetail, 'subtot')),2, '.', '');
      $this->tot = number_format($this->tot1 - $this->ksm,2, '.', '');
      $this->rebh = number_format(array_sum(array_column($this->orderdetail, 'rebh')),2, '.', '');

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
