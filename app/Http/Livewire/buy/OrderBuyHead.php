<?php

namespace App\Http\Livewire\Buy;


use App\Models\buy\buys;
use App\Models\jeha\jeha;
use App\Models\stores\halls_names;
use App\Models\stores\items;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class OrderBuyHead extends Component
{
  public $ToSal_L;
  public $ToSal=false;

    public $order_no;
    public $order_date;
    public $jeha;
    public $jeha_type;
    public $st_no;
    public $st_nol;
    public $st_name;
    public $jeha_name;
    public $Charge_Tot=0;
    public $ChargeDetail=[];

  public $TheJehaIsSelected;
  public $HeadOpen;
  public $HeadDataOpen;

    protected $listeners = [
        'mounthead','jehaadded','TakeCharge'
    ];

  public function ChkToSal_No(){
    if ($this->ToSal_L!=null) {
      $res=halls_names::on(Auth()->user()->company)->find($this->ToSal_L);
      if ($res) {$this->emit('gotohead','head-btn');}
      else {$this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');}
    }

  }

    public function TakeCharge($charge,$tot){
      $this->ChargeDetail=$charge;
      $this->Charge_Tot=$tot;

    }
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
            $this->emit('gotonext','storeno');
        }
        if ($field=='jeha'){
            $this->jeha_name='';
            $this->jeha_type=0;
            if ($this->jeha!=null) {
                $result = jeha::on(Auth()->user()->company)->where('jeha_type',2)->where('jeha_no',$this->jeha)->first();

                if ($result) {  $this->jeha_name=$result->jeha_name;
                    $this->jeha_type=$result->jeha_type;
                    $this->emit('jehafound',$this->jeha,$this->jeha_name);
                }}
        }
    }

    public function jehaadded($wj){
      $this->jeha=$wj;
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

    public function mounthead(){

        $this->mount();
    }

    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [
            'order_no' => ['required','integer','gt:0', 'unique:other.buys,order_no'],
            'order_date' => 'required',
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

        $this->order_no=buys::on(Auth()->user()->company)->max('order_no')+1;
        $this->order_date=date('Y-m-d');
        $this->st_no='1';
        $this->st_nol=1;
        $this->st_name='المخزن الرئيسي';
        $this->jeha='2';
        $this->jeha_name='مشتريات عامة';
        $this->jeha_type='2';
        $this->HeadOpen=True;
        $this->HeadDataOpen=false;
        $this->Charge_Tot=0;
    }

    public function BtnHeader()
    {
        $this->validate();
        if ($this->ToSal){
         if ($this->ToSal_L==null || !(halls_names::on(auth()->user()->company)->where('hall_no',$this->ToSal_L)->exists()) ){
          $this->dispatchBrowserEvent('mmsg', 'يجب ادخال رقم صالة صحيح');
          return false;
          }
        }
        $this->st_name=stores_names::on(Auth()->user()->company)
            ->where('st_no',$this->st_no)->first()->st_name;
        $this->HeadOpen=false;
        $this->HeadDataOpen=true;
        $this->emitTo('buy.order-buy-table','TakeChargeAll',$this->ChargeDetail,$this->Charge_Tot);
        $this->emitTo('buy.charge-buy','open',false);
        $this->emitTo('buy.order-buy-table','open',true);
        $this->emit('HeadBtnClick',$this->order_no,$this->order_date,$this->jeha,$this->st_no,$this->ToSal,$this->ToSal_L);
        $this->emitTo('buy.order-buy-detail','TakeParam',$this->order_no,$this->st_no);
        $this->emit('mountdetail');

    }


    public function render()
    {
        return view('livewire.buy.order-buy-head',[
            'jeha'=>jeha::on(Auth()->user()->company)->where('jeha_type',2)->where('available',1)->get(),
            'stores'=>stores::on(Auth()->user()->company)->where('raseed','>',0)->get(),
            'stores_names'=>stores_names::on(Auth()->user()->company)->get(),
            'halls_names'=>halls_names::all(),
            'items'=>items::on(Auth()->user()->company)->where('raseed','>',0)->get(),
            'jeha_name'=>$this->jeha_name,


        ]);
    }
}
