<?php

namespace App\Http\Livewire\Buy;

use App\Models\buy\buy_tran;
use App\Models\buy\buy_tran_work;
use App\Models\buy\buy_tran_work_view;
use App\Models\buy\buys;
use App\Models\buy\buys_work;
use App\Models\buy\charges_buy;
use App\Models\buy\charges_buy_work;
use App\Models\buy\rep_buy_tran;
use App\Models\jeha\jeha;
use App\Models\stores\halls;
use App\Models\stores\halls_names;
use App\Models\stores\item_price_sell;
use App\Models\stores\items;
use App\Models\stores\store_exp;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use App\Models\trans\trans;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderBuy extends Component
{
    public $ToSal_L;
    public $ToSal=false;

    public $order_no;
    public $order_date;
    public $jeha_no;
    public $jeha_type;
    public $st_no=1;
    public $st_nol;
    public $st_name;
    public $jeha_name;
    public $Charge_Tot=0;
    public $ItemToEdit;
    public $ShowEditItem=false;

    public $item_no;
    public $item_name;
    public $st_raseed;
    public $raseed;
    public $quant;
    public $price;
    public $ksm=0;
    public $madfooh=0;
    public $tot1;
    public $tot;



    public $notes;
    public $TheDelete;


    public $IsSave=false;

    public $ItemGeted=false;
    public $TheItemIsSelected;

    public $TheJehaIsSelected;
    public $ThePlace1ListIsSelected;

    public $OpenTable=true;
    public $xcharge_open=false;
    public $OpenSave=false;

    public $price_nakdy;
    public $price_tak;

  protected $listeners = [
    'openTable','DoDelete'
  ];

    public function UpdNakdy(){
      if (!$this->item_no) return;
      if (!$this->price_nakdy || $this->price_nakdy<=0) return;
        items::find($this->item_no)->update(['price_sell'=>$this->price_nakdy]);
      $res=item_price_sell::where('item_no',$this->item_no)->where('price_type',1)->first();
        if ($res) {$res->price=$this->price_nakdy;$res->save();}
      else item_price_sell::create(['item_no'=>$this->item_no,'price_type'=>1,'price'=>$this->price_nakdy]);
        $this->emit('gotonext','price_tak');
    }
    public function UpdTak(){
        if (!$this->item_no) return;
        if (!$this->price_tak || $this->price_tak<=0) return;

        $res=item_price_sell::where('item_no',$this->item_no)->where('price_type',2)->first();
        if ($res) {$res->price=$this->price_tak;$res->save();}
        else item_price_sell::create(['item_no'=>$this->item_no,'price_type'=>2,'price'=>$this->price_tak]);
        $this->emit('gotonext','quant');
    }

    public function updated($field)
    {
        if ($field=='st_nol') {
            $this->st_no=$this->st_nol;
        }
        if ($field=='st_no') {
            $this->st_nol=$this->st_no;
            $this->ChkSt_no();}

        if ($field=='TheJehaIsSelected'){
            $this->TheJehaIsSelected=0;
            $this->ChkJeha_no();
        }
        if ($field=='ThePlace1ListIsSelected'){
            $this->ThePlace1ListIsSelected=0;
            $this->ChkSt_no();
        }
        if ($field=='TheItemIsSelected'){
          $this->TheItemIsSelected=0;
          $this->ChkItemAndGo();
        }
        if ($field=='jeha_no'){
            $this->jeha_name='';
            $this->jeha_type=0;
            if ($this->jeha_no!=null) {
              $result = jeha::where('jeha_type',2)->where('jeha_no',$this->jeha_no)->first();
                if ($result) {  $this->jeha_name=$result->jeha_name;
                    $this->jeha_type=$result->jeha_type;
                  $this->ChkJeha_no();
                }}
        }
    }
    public function ChkSt_no(){
        if ($this->st_no)
        {
            buys_work::where('emp',Auth::user()->empno)->update(['place_no'=>$this->st_no]);
            $this->emit('gotonext','theitem');
        }
    }
    public function DoEditItem(){
        $this->ShowEditItem=true;
        $this->ItemToEdit=$this->item_name;

        $this->emit('gotonext','ItemToEdit');

    }
    public function edititem($item)
    {
        $res=buy_tran_work_view::where('emp',Auth::user()->empno)
            ->where('item_no',$item)->first();
        $this->item_no=$res->item_no;
        $this->item_name=$res->item_name;
        $this->quant=$res->quant;
        $this->price=$res->price ;
        $this->emit('gotonext', 'quant');
    }
    public function removeitem($item)    {
        $this->TheDelete=$item;
        $this->dispatchBrowserEvent('dodelete');
    }
    public function DoDelete(){

        buy_tran_work::where('emp',Auth::user()->empno)->where('item_no',$this->TheDelete)->delete();
        $this->render();
    }
  public function SaveItem(){
        if ($this->ItemToEdit!=null){
            items::where('item_no',$this->item_no)->update(['item_name'=>$this->ItemToEdit]);
            $this->item_name = $this->ItemToEdit;
            $this->ShowEditItem = false;
            $this->emit('gotonext','quant');
        }
    }
  public function ChkToSal_No(){
    if ($this->ToSal_L!=null) {
      $res=halls_names::find($this->ToSal_L);
      if (!$res) $this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');
    }

  }
  public function OpenCharge(){
    $this->xcharge_open=true;
    $this->OpenTable=false;
    $this->emitTo('buy.charge-buy2','open',true);
  }
  public function openTable($open){

      $this->OpenTable=$open;
  }
  public function ChkItemAndGo(){
    $this->item_name='';

    if ($this->item_no!=null) {
      $result=items::with('iteminstore')
        ->where('item_no', $this->item_no)->first();
      if ($result) {
        $this->item_name=$result->item_name;
        $this->price=number_format($result->price_buy, 2, '.', '')  ;
        $this->raseed= $result->raseed;
        $this->st_raseed=0;

        $this->price_nakdy=$result->price_sell;
        $item_price_sell=item_price_sell::where('item_no',$this->item_no)->where('price_type',2)->first();
        if ($item_price_sell) $this->price_tak=$item_price_sell->price;
        else $this->price_tak=0;

        for ($i=0;$i<count($result->iteminstore);$i++)
        { if($result->iteminstore[$i]->st_no==$this->st_no){$this->st_raseed=$result->iteminstore[$i]->raseed;}}

        $res=buy_tran_work::where('item_no',$this->item_no)->where('emp',Auth::user()->empno)->first();
        if ($res && (!$this->quant || $this->quant==0)) {
          $this->quant=$res->quant;

        }
        if ($res)  $this->price=$res->price;
        $this->ItemGeted=true;


        $this->emit('gotonext','quant');
        return true;
      } else $this->emit('gotonext','item_no'); return false; }
    $this->emit('gotonext','item_no'); return false;
  }
  public function ChkQuantAndGo(){
    if ($this->quant){

      $this->emit('gotonext','price');
      return true;
    } else $this->emit('gotonext','quant'); return false;

  }

  public function ChkOrder_date(){
    if ($this->order_date)
    {
      buys_work::where('emp',Auth::user()->empno)->update(['order_date'=>$this->order_date]);
      $this->emit('gotonext','jeha_no');
    }
  }
  public function ChkJeha_no(){
    if ($this->jeha_no)
    {
      buys_work::where('emp',Auth::user()->empno)->update(['jeha'=>$this->jeha_no]);
      $this->emit('gotonext','st_no');
    }
  }

  public function ChkKsm(){
    if ($this->ksm)
    {
      buys_work::where('emp',Auth::user()->empno)->update(['ksm'=>$this->ksm]);
      $this->emit('gotonext','madfooh');
    }
  }
  public function ChkMadfooh(){
    if ($this->ksm)
    {
      buys_work::where('emp',Auth::user()->empno)->update(['cash'=>$this->madfooh]);
      $this->emit('gotonext','ksm');
    }
  }

  public function ChkPriceAndGo()
  {
    if (!$this->item_no) return false;
    if (!items::where('item_no', $this->item_no)->exists())  return false;
    if (!$this->quant) return false;
    if (buy_tran_work::where('item_no',$this->item_no)
      ->where('emp',Auth::user()->empno)
      ->exists())
     buy_tran_work::where('item_no',$this->item_no)
       ->where('emp',Auth::user()->empno)->update([
         'quant'=>$this->quant,'price_input'=>$this->price,'price'=>$this->price]);
    else
      buy_tran_work::insert([
        'order_no'=>0,'item_no'=>$this->item_no,'emp'=>Auth::user()->empno,'tarjeeh'=>0,
        'quant'=>$this->quant,'price_input'=>$this->price,'price'=>$this->price
      ]);
    $this->ClearData();
      $this->emit('gotonext','theitem');
  }
  public function ClearData () {
    $this->raseed=0;
    $this->st_raseed=0;
    $this->item_no=0;
    $this->item_name='';
    $this->quant=1;
    $this->price=number_format(0, 2, '.', '');
  }
    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [
            'order_no' => ['required','integer','gt:0', 'unique:other.buys,order_no'],
            'order_date' => ['required','date'],
            'jeha_type' => ['integer','size:2'],
            'st_no' => ['required','integer','gt:0', 'exists:other.stores_names,st_no'],
        ];
    }
    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',
        'unique' => 'هذا الرقم مخزون مسبقا',
        'size' => 'هذا العميل ليس من الموردين',
        'order_date.required'=>'يجب ادخال تاريخ صحيح',
    ];
    public function OpenModal(){
        $this->emitTo('jeha.add-supp','WithJehaType',2);
        $this->dispatchBrowserEvent('OpenModal');
    }
    public function CloseModal(){
        $this->dispatchBrowserEvent('CloseModal');
    }

  public function OpenFirst(){

    $this->dispatchBrowserEvent('OpenFirst');
    $this->emitTo('stores.add-item','gotoitem','item_add');


  }
  public function CloseFirst(){
    $this->dispatchBrowserEvent('CloseFirst');
  }
  public function CloseSecond(){
    $this->dispatchBrowserEvent('CloseSecond');
    $this->dispatchBrowserEvent('OpenFirst');
    $this->emitTo('stores.add-item','gotoitem','item_add');
  }


  public function pre_store(){
    if (!buy_tran_work::where('emp',Auth::user()->empno)->exists()) {
      session()->flash('message', 'لم يتم ادخال اصناف بعد');
      return false;
    }
   $this->OpenSave=true;
   $this->order_no=buys::max('order_no')+1;
   $this->emit('gotonext','order_no');

  }
  public function store(){
    if (!buy_tran_work::where('emp',Auth::user()->empno)->exists()){
      session()->flash('message', 'لم يتم ادخال اصناف بعد');
      return false;
    }
    if (buys::where('order_no',$this->order_no)->exists()) {
      session()->flash('message', 'هذا الرقم مخزون مسبقاً');
      return false;
    }
     $this->validate();
      DB::connection(Auth()->user()->company)->beginTransaction();
      try {
        DB::connection(Auth()->user()->company)->table('buys')->insert([
          'order_no' => $this->order_no,
          'order_no2' => 0,
          'jeha' => $this->jeha_no,
          'order_date' => $this->order_date,
          'order_date_input' => date('Y-m-d'),
          'notes' => $this->notes,
          'price_type' => 1,
          'tot1' => $this->tot1,
          'ksm' => $this->ksm,
          'tot' => $this->tot,
          'tot_charges' => $this->Charge_Tot,
          'cash' => $this->madfooh,
          'not_cash' => $this->tot - $this->madfooh,
          'place_no' => $this->st_no,
          'tran_no' => 0,
          'emp' => Auth::user()->empno,
          'available' => 0
        ]);
        $orderdetail=buy_tran_work::where('emp',Auth::user()->empno)->get();
        foreach ($orderdetail as $item) {
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
        if ($this->madfooh != 0) {

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

        if ($this->Charge_Tot!=0){
          $ChargeDetail=charges_buy_work::where('emp',Auth::user()->empno)->get();

          foreach ($ChargeDetail as $item) {
            charges_buy::on(Auth()->user()->company)->insert([
              'order_no'=>$this->order_no,
              'charge_type'=>$item['charge_type'],
              'charge_by' => $item['charge_by'],
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
          items::on(Auth::user()->company)->where('item_no', $item->item_no)
            ->update(['price_cost' => $tot / $item->raseed]);
        }

        if ($this->ToSal) {
          $per_no = store_exp::on(Auth()->user()->company)->max('per_no') + 1;
          for ($i = 0; $i < count($orderdetail); $i++) {
            $item = $orderdetail[$i];

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

              $from = stores::where('st_no', $this->st_no)->where('item_no',$item['item_no'])->first();
              $to = halls::where('hall_no', $this->ToSal_L)->where('item_no', $item['item_no'])->first();
              if (!$to) {halls::insert(['hall_no' => $this->ToSal_L, 'item_no' => $item['item_no'],'raseed'=>0]);
                  $to = halls::where('hall_no', $this->ToSal_L)->where('item_no', $item['item_no'])->first();}

              $from->raseed -= $item['quant'];
              $from->save();
              $to->raseed += $item['quant'];
              $to->save();

          }
        }
        DB::connection(Auth()->user()->company)->commit();
        $this->IsSave=true;
        $this->OpenSave=false;
        charges_buy_work::where('emp',Auth::user()->empno)->delete();
        buy_tran_work::where('emp',Auth::user()->empno)->delete();
        buys_work::where('emp',Auth::user()->empno)->delete();
        $this->NewBuys();
      } catch (\Exception $e) {
        info($e);
        $this->dispatchBrowserEvent('mmsg','حدث خطأ');
        DB::connection(Auth()->user()->company)->rollback();
      }
  }

  public function NewBuys(){
    $this->order_no = 0;
    $this->order_date = date('Y-m-d');
    $this->st_no = 1;
    $this->st_nol = 1;
    $this->st_name = 'المخزن الرئيسي';
    $this->jeha_no = '2';
    $this->jeha_name = 'مشتريات عامة';
    $this->jeha_type = '2';

    $this->Charge_Tot = 0;
    buys_work::insert([
      'order_no' => $this->order_no,
      'order_no2' => 0,
      'jeha' => $this->jeha_no,
      'order_date' => $this->order_date,
      'order_date_input' => date('Y-m-d'),

      'price_type' => 1,
      'tot1' => 0,
      'ksm' => 0,
      'tot' => 0,
      'tot_charges' => 0,
      'cash' => 0,
      'not_cash' =>0,
      'place_no' => $this->st_no,
      'tran_no' => 0,
      'emp' => Auth::user()->empno,
      'available' => 0,
    ]);
  }

  public function mount()
  {
    $this->OpenSave=false;
    if (buys_work::where('emp',Auth::user()->empno)->exists())
    {
      $res=buys_work::where('emp',Auth()->user()->empno)->first();
      $this->order_date=$res->order_date;
      $this->st_no=$res->place_no;
      $this->st_nol=$res->st_no;
      $this->st_name=stores_names::find($this->st_no)->st_name;
      $this->jeha_no=$res->jeha;

      $this->jeha_name=jeha::find($this->jeha_no)->jeha_name;
      $this->jeha_type='2';
      $this->Charge_Tot=0;
      $this->madfooh=$res->cash;
    }
    else {
      $this->NewBuys();
    }


  }
    public function render()
    {
        $this->Charge_Tot = number_format(charges_buy_work::where('emp',Auth::user()->empno)->sum('val'),2, '.', '');
        $this->tot1=number_format(buy_tran_work_view::where('emp',Auth::user()->empno)->sum('subtot'), 2, '.', '');
        $this->tot=number_format($this->tot1-$this->ksm, 2, '.', '');
        $this->madfooh=number_format( $this->madfooh, 2, '.', '');
        $this->ksm=number_format($this->ksm, 2, '.', '');

        return view('livewire.buy.order-buy',[
            'orderdetail'=>buy_tran_work_view::where('emp',Auth::user()->empno)->get(),
            'stores_names'=>stores_names::get(),
            'halls_names'=>halls_names::get(),
        ]);
    }
}
