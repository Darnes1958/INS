<?php

namespace App\Http\Livewire\Sell;

use App\Models\sell\sells;
use App\Models\jeha\jeha;
use App\Models\stores\halls_names;
use App\Models\stores\items;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderSellHead extends Component
{
    public $order_no;
    public $order_date;
    public $jeha;
    public $jeha_type;
    public $stno;
    public $storel;
    public $st_name;
    public $jeha_name;

    public $OredrSellRadio='Makazen';
    public $PlaceLabel='المخزن';



    public $stores_names;
    public $halls_names;
    public $HeadOpen;
    public $HeadDataOpen;

  protected $listeners = [
    'mounthead','jehaadded','Take_Search_JehaNo',
  ];
  public function PlaceKeyEnter(){
    $this->storel='';
    Config::set('database.connections.other.database', Auth::user()->company);
    if ($this->stno!=null) {
      if ($this->OredrSellRadio=='Makazen'){
        $res=stores_names::find($this->stno);
        if ($res) {$this->storel=$res->st_no;}
        else  $this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون ؟');
      }
      if ($this->OredrSellRadio=='Salat'){
        $res=halls_names::find($this->stno);
        if ($res) {$this->storel=$res->hall_no;}
        else $this->dispatchBrowserEvent('MyMsg','نحن هنا');
      }
      if ($res) {$this->emit('gotonext','head-btn');}

    }
  }
  public function ChangePlace(){
    if ($this->OredrSellRadio=='Makazen') {
      $this->dispatchBrowserEvent('MyMsg','نحن هنا');
      $this->PlaceLabel ='المخزن';
    } else
    {
      $this->dispatchBrowserEvent('MyMsg','نحن هنا');
      $this->PlaceLabel ='الصالة';
    }
  }

  public function updatedStno()
    {
        $this->storel=$this->stno;
    }

    public function updatedStorel()
    {
        $this->stno=$this->storel;
        $this->emit('gotonext', 'storeno');

    }

  public function JehaKeyDown(){
    if ($this->jeha !=null){
      Config::set('database.connections.other.database', Auth::user()->company);
      $res=jeha::find($this->jeha);
      if ($res){
        $this->jeha_name=$res->jeha_name;
        $this->emit('gotonext','orderno');
      }
    }

  }
  public function Take_Search_JehaNo($jeha_no){

    $this->jeha=$jeha_no;

    $this->JehaKeyDown();


  }
    public function OpenJehaSerachModal(){
      $this->dispatchBrowserEvent('OpenSelljehaModal');
    }
    public function CloseJehaSerachModal(){
      $this->dispatchBrowserEvent('CloseSelljehaModal');
    }
    public function jehaadded($wj){
        $this->jeha=$wj;
    }
    public function OpenModal(){
        $this->dispatchBrowserEvent('OpenModal');
    }
    public function CloseModal(){
        $this->dispatchBrowserEvent('CloseModal');
    }

    public function mounthead(){

        $this->mount();
    }


    public function updatedJeha()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        $this->jeha_name='';
        $this->jeha_type=0;
        if ($this->jeha!=null) {
            $result = jeha::where('jeha_type',2)->where('jeha_no',$this->jeha)->first();

            if ($result) {  $this->jeha_name=$result->jeha_name;
                $this->jeha_type=$result->jeha_type;
                $this->emit('jehafound',$this->jeha,$this->jeha_name);
            }}
    }

    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);

        return [
            'order_no' => ['required','integer','gt:0', 'unique:other.buys,order_no'],
            'order_date' => 'required',
            'jeha_type' => ['integer','size:2'],
            'stno' => ['required','integer','gt:0', 'exists:other.stores_names,st_no'],
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
        Config::set('database.connections.other.database', Auth::user()->company);
        $this->order_no=sells::max('order_no')+1;
        $this->order_date=date('Y-m-d');
        $this->stno='1';
        $this->st_name='المخزن الرئيسي';
        $this->jeha='2';
        $this->jeha_name='مشتريات عامة';
        $this->jeha_type='2';
        $this->HeadOpen=True;
        $this->HeadDataOpen=false;
    }

    public function BtnHeader()
    {
        $this->validate();
        $this->HeadOpen=false;
        $this->HeadDataOpen=true;
        $this->emit('HeadBtnClick',$this->order_no,$this->order_date,$this->jeha,$this->stno,$this->OredrSellRadio);
        $this->emit('mountdetail',$this->stno,$this->OredrSellRadio);
    }

    public function render()
    {

        Config::set('database.connections.other.database', Auth::user()->company);
        $this->stores_names=stores_names::all();
        $this->halls_names=halls_names::all();


        return view('livewire.sell.order-sell-head',[
            'jeha'=>jeha::where('jeha_type',1)->where('available',1)->get(),
            'stores'=>stores::where('raseed','>',0)->get(),
            'stores_names'=>$this->stores_names,
            'halls_names'=>$this->halls_names,
            'items'=>items::on('other')->where('raseed','>',0)->get(),
            'jeha_name'=>$this->jeha_name,
            // 'date' => date('Y-m-d'),
            // 'wid' => buys::max('order_no')+1,
        ]);
    }
}

