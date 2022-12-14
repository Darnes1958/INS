<?php

namespace App\Http\Livewire\Buy;

use App\Models\buy\buys;
use App\Models\jeha\jeha;
use App\Models\stores\items;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class OrderBuyHead extends Component
{
    public $order_no;
    public $order_date;
    public $jeha;
    public $jeha_type;
    public $stno;
    public $storel;
    public $st_name;
    public $jeha_name;


  public function updatedStno()
  {
    $this->storel=$this->stno;
  }

  public function updatedStorel()
  {
    $this->stno=$this->storel;
    $this->emit('gotonext', 'storeno');

  }

  public $TheJehaIsSelected;
  public $HeadOpen;
  public $HeadDataOpen;

    protected $listeners = [
        'mounthead','jehaadded',
    ];

  public function updatedTheJehaIsSelected(){
    $this->TheJehaIsSelected=0;
    $this->emit('gotonext','storeno');
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

    public function mounthead(){

        $this->mount();
    }


    public function updatedJeha()
    {

        $this->jeha_name='';
        $this->jeha_type=0;
        if ($this->jeha!=null) {
        $result = jeha::on(Auth()->user()->company)->where('jeha_type',2)->where('jeha_no',$this->jeha)->first();

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
        'required' => '???? ???????? ?????? ????????',
        'unique' => '?????? ?????????? ?????????? ??????????',
        'size' => '?????? ???????????? ?????? ???? ????????????????',
        'order_date.required'=>'?????? ?????????? ?????????? ????????',
    ];

    public function mount()
    {

        $this->order_no=buys::on(Auth()->user()->company)->max('order_no')+1;
        $this->order_date=date('Y-m-d');
        $this->stno='1';
        $this->st_name='???????????? ??????????????';
        $this->jeha='2';
        $this->jeha_name='?????????????? ????????';
        $this->jeha_type='2';
        $this->HeadOpen=True;
        $this->HeadDataOpen=false;
    }

    public function BtnHeader()
    {
        $this->validate();
        $this->HeadOpen=false;
        $this->HeadDataOpen=true;
        $this->emit('HeadBtnClick',$this->order_no,$this->order_date,$this->jeha,$this->stno);
        $this->emitTo('buy.order-buy-detail','TakeParam',$this->order_no,$this->stno);
        $this->emit('mountdetail');
    }


    public function render()
    {


        return view('livewire.buy.order-buy-head',[
            'jeha'=>jeha::on(Auth()->user()->company)->where('jeha_type',2)->where('available',1)->get(),
            'stores'=>stores::on(Auth()->user()->company)->where('raseed','>',0)->get(),
            'stores_names'=>stores_names::on(Auth()->user()->company)->get(),
            'items'=>items::on(Auth()->user()->company)->where('raseed','>',0)->get(),
            'jeha_name'=>$this->jeha_name,


        ]);
    }
}
