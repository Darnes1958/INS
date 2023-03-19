<?php

namespace App\Http\Livewire\Buy;

use App\Models\buy\buy_tran_work;
use App\Models\buy\buy_tran_work_view;
use App\Models\buy\buys;
use App\Models\buy\buys_work;
use App\Models\buy\rep_buy_tran;
use App\Models\jeha\jeha;
use App\Models\stores\halls_names;
use App\Models\stores\items;
use App\Models\stores\stores_names;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
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
    public $OrderChanged=false;
    public $ChargeDetail=[];
    public $ChargeTot;
    public $IsSave=false;

    public $ItemGeted=false;
    public $TheItemIsSelected;

    public $TheJehaIsSelected;

    public buy_tran_work $Record;

    public function updated($field)
    {
        if ($field=='st_nol') {
            $this->st_no=$this->st_nol;
            $this->emit('gotonext', 'st_no');
        }
        if ($field=='st_no')
            $this->st_nol=$this->st_no;


        if ($field=='TheJehaIsSelected'){
            $this->TheJehaIsSelected=0;
            $this->emit('gotonext','st_no');
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
                }}
        }
    }
    public function DoEditItem(){
        $this->ShowEditItem=true;
        $this->ItemToEdit=$this->item_name;

        $this->emit('gotonext','ItemToEdit');

    }
    public function SaveItem(){
        if ($this->ItemToEdit!=null){
            items::find($this->item)->update(['item_name'=>$this->ItemToEdit]);
            $this->item_name = $this->ItemToEdit;
            $this->ShowEditItem = false;
            $this->emit('gotonext','quant');
        }
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
        for ($i=0;$i<count($result->iteminstore);$i++)
        { if($result->iteminstore[$i]->st_no==$this->stno){$this->st_raseed=$result->iteminstore[$i]->raseed;}}

        $res=buy_tran_work::where('item_no',$this->item_no)->where('emp',Auth::user()->empno)->first();
        if ($res && (!$this->quant || $this->quant==0)) {
          $this->quant=$res->quant;
          $this->price=$res->price;
        }
        $this->ItemGeted=true;

        $this->emit('gotonext','quant');
        return true;
      } $this->emit('gotonext','item_no'); return false; }
    $this->emit('gotonext','item_no'); return false;
  }
  public function ChkQuantAndGo(){
    if ($this->quant){

      $this->emit('gotonext','price');
      return true;
    } else $this->emit('gotonext','quant'); return false;

  }
  public function ChkPriceAndGo()
  {

    if (!$this->ChkItemAndGo()) return false;

    if (!$this->ChkQuantAndGo()) return false;

    if (buy_tran_work::where('order_no',$this->order_no)
      ->where('item_no',$this->item_no)
      ->where('emp',Auth::user()->empno)
      ->exists())
     buy_tran_work::where('order_no',$this->order_no)
       ->where('item_no',$this->item_no)
       ->where('emp',Auth::user()->empno)->update([
         'quant'=>$this->quant,'price_input'=>$this->price,'price'=>$this->price]);
    else
      buy_tran_work::insert([
        'order_no'=>$this->order_no,'item_no'=>$this->item_no,'emp'=>Auth::user()->empno,'tarjeeh'=>0,
        'quant'=>$this->quant,'price_input'=>$this->price,'price'=>$this->price
      ]);


    $this->ClearData();
    $this->render();
    $this->emit('gotonext','item_no');
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

    public function mount()
    {
      if (buys_work::where('emp',Auth::user()->empno)->exists())
      {
        $res=buys_work::where('emp',Auth()->user()->empno)->first();
        $this->order_no=$res->order_no;
        $this->order_date=$res->order_date;
        $this->st_no=$res->place_no;
        $this->st_nol=$res->st_no;
        $this->st_name=stores_names::find($this->st_no)->st_name;
        $this->jeha_no=$res->jeha;
        $this->jeha_name=jeha::find($this->jeha_no)->jeha_name;
        $this->jeha_type='2';
        $this->Charge_Tot=0;
      }
      else {
        $this->order_no = buys::on(Auth()->user()->company)->max('order_no') + 1;
        while (true){
          if ( ! buys_work::where('order_no',$this->order_no)->exists()) break;
          $this->order_no+=1;
        }

        $this->order_date = date('Y-m-d');
        $this->st_no = '1';
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


    }

    public function OpenModal(){
        $this->emitTo('jeha.add-supp','WithJehaType',2);
        $this->dispatchBrowserEvent('OpenModal');
    }
    public function CloseModal(){
        $this->dispatchBrowserEvent('CloseModal');
    }
    public function OpenCharge(){

        $this->emitTo('buy.charge-buy','open',true);
        $this->emitTo('buy.order-buy-table','open',false);
    }
  public function OpenFirst(){
    $this->dispatchBrowserEvent('OpenFirst');
  }
  public function CloseFirst(){
    $this->dispatchBrowserEvent('CloseFirst');
  }
  public function CloseSecond(){
    $this->dispatchBrowserEvent('CloseSecond');
    $this->dispatchBrowserEvent('OpenFirst');
    $this->emit('gotoaddonetype');
  }
    public function render()
    {
        $this->tot1=number_format(buy_tran_work_view::where('emp',Auth::user()->empno)->sum('subtot'), 2, '.', '');
        $this->tot=number_format($this->tot1-$this->madfooh-$this->ksm, 2, '.', '');
        $this->madfooh=number_format($this->madfooh, 2, '.', '');
        $this->ksm=number_format($this->ksm, 2, '.', '');
        return view('livewire.buy.order-buy',[
            'orderdetail'=>buy_tran_work_view::where('emp',Auth::user()->empno)->get(),
            'stores_names'=>stores_names::get(),
            'halls_names'=>halls_names::get(),
        ]);
    }
}
