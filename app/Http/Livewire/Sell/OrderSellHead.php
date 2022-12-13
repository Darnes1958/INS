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
use Illuminate\Validation\Rule;
use Livewire\Component;

class OrderSellHead extends Component
{
    public $order_no;
    public $order_date;
    public $jeha_no;
    public $jeha_type;
    public $stno=1;
    public $storel;
    public $st_name;
    public $jeha_name;

    public $OredrSellRadio='Makazen';
    public $PlaceLabel='المخزن';

    public $price_type=1;

    public $stores_names;
    public $halls_names;
    public $HeadOpen;
    public $HeadDataOpen;
    public $ThePriceListIsSelected;

  protected $listeners = [
    'mounthead','jehaadded','Take_Search_JehaNo',
  ];

  public function updatedThePriceListIsSelected(){
    $this->ThePriceListIsSelected=0;
    $this->emit('gotonext','jehano');

  }


  public function PlaceKeyEnter(){

    if ($this->ChkPlace()=='ok') { $this->emit('gotonext','head-btn');}
}
public function ChkPlace(){
    $this->storel='';
    Config::set('database.connections.other.database', Auth::user()->company);
    if ($this->stno!=null) {
        if ($this->OredrSellRadio=='Makazen'){
            $res=stores_names::find($this->stno);
            if ($res) {$this->storel=$res->st_no; $this->st_name=$res->st_name; return('ok');}
            else  {$this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون ؟'); return('not');}
        }
        if ($this->OredrSellRadio=='Salat'){
            $res=halls_names::find($this->stno);
            if ($res) {$this->storel=$res->hall_no; $this->st_name=$res->hall_name;return('ok');}
            else {$this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');return('not');}
        }
      }
    else {return ('empty');}
}
  public function ChangePlace(){
    if ($this->OredrSellRadio=='Makazen') {

      $this->PlaceLabel ='المخزن';
    } else
    {

      $this->PlaceLabel ='الصالة';
    }
  }

    public function updatedStorel()
    {
         $this->FillStno();
    }
    public function FillStno(){
        $this->stno=$this->storel;
        $this->emit('gotonext', 'storeno');

    }

  public function Chkjeha(){
      if ($this->jeha_no !=null ) {
          Config::set('database.connections.other.database', Auth::user()->company);
          $this->jeha_name = '';
          $this->jeha_type = 0;
          $res = jeha::find($this->jeha_no);
          if ($res) {
              if ($res->jeha_no==1) {return('amaa');}
              if ($res->jeha_type==2) {return('supp');}
              $this->jeha_name = $res->jeha_name;
              $this->jeha_type = $res->jeha_type;
              return ('ok');
          } else {
              $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ؟');
              return ('not');
          }
      } else {return ('empty');}
  }
  public function JehaKeyDown(){
      $res=$this->Chkjeha();
      if ($res =='ok')  {
        $this->emit('gotonext','orderno');
      }
      if ($res =='amaa') {
          $this->dispatchBrowserEvent('mmsg', 'لا تجوز المبيعات العامة هنا ؟');
      }
      if ($res =='supp')  {
          $this->dispatchBrowserEvent('mmsg', 'هذا العميل من الموردين وليس الزبائن ؟');
      }
  }

  public function Take_Search_JehaNo($jeha_no){
    $this->jeha_no=$jeha_no;
    $this->JehaKeyDown();
    }
    public function OpenJehaSerachModal(){
      $this->dispatchBrowserEvent('OpenSelljehaModal');
    }
    public function CloseJehaSerachModal(){
      $this->dispatchBrowserEvent('CloseSelljehaModal');
    }
    public function jehaadded($wj){
        $this->jeha_no=$wj;
    }
    public function OpenModal(){
      $this->emitTo('jeha.add-supp','WithJehaType',1);
        $this->dispatchBrowserEvent('OpenModal');
    }
    public function CloseModal(){
        $this->dispatchBrowserEvent('CloseModal');
    }

    public function mounthead(){

        $this->mount();
    }


    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);

        return [
            'order_no' => ['required','integer','gt:0', 'unique:other.sells,order_no'],
            'jeha_no' =>['required','integer','gt:1', Rule::exists('other.jeha')->where(function ($query) {
                $query->where('jeha_type', 1);
            })],
            'order_date' => 'required',
            'jeha_type' => ['integer','size:1'],

        ];
    }
    protected $messages = [
        'exists' => 'هذا الرقم غير مخزون',
        'required' => 'لا يجوز ترك فراغ',
        'unique' => 'هذا الرقم مخزون مسبقا',
        'size' => ' هذا العميل ليس من الزبائن',
        'order_date.required'=>'يجب ادخال تاريخ صحيح',
    ];

    public function mount()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        $this->order_no=sells::max('order_no')+1;
        $this->order_date=date('Y-m-d');
        $this->stno;
        $this->st_name;
        $this->jeha_no;
        $this->jeha_name;
        $this->jeha_type='2';
        $this->HeadOpen=True;
        $this->HeadDataOpen=false;
    }

    public function BtnHeader()
    {
        $this->validate();
        if ($this->ChkPlace()=='empty') {$this->dispatchBrowserEvent('mmsg', 'يجب ادخال نقطة البيع ؟'); return(false);}
        $this->HeadOpen=false;
        $this->HeadDataOpen=true;
        $this->emit('HeadBtnClick',$this->order_no,$this->order_date,$this->jeha_no,$this->OredrSellRadio,$this->stno,$this->price_type);
        $this->emit('mountdetail',$this->OredrSellRadio,$this->stno,$this->st_name,$this->price_type);
        return (true);
    }

    public function render()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        $this->stores_names=stores_names::all();
        $this->halls_names=halls_names::all();
        return view('livewire.sell.order-sell-head',[
            'stores_names'=>$this->stores_names,
            'halls_names'=>$this->halls_names,
        ]);
    }
}

