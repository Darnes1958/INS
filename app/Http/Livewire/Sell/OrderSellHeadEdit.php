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

class OrderSellHeadEdit extends Component
{
    public $order_no;
    public $order_date;
    public $jeha_no;
    public $jeha_type;
    public $stno=1;
    public $storel;
    public $st_name;
    public $jeha_name;

    public $OrderSellRadio='Makazen';
    public $PlaceLabel='المخزن';

  public $ksm;
  public $madfooh;
  public $tot1;
  public $tot;
  public $orderdetail=[];
  public $notes;

  public $OrderNoFound=false;

    public $stores_names;
    public $halls_names;
    public $HeadOpen;
    public $HeadDataOpen;

    public $TheOrderListSelected;

  protected $listeners = [
    'mounthead',
  ];

  public function updatedTheOrderListSelected(){
    $this->TheOrderListSelected=0;
    $this->ChkOrderNoANdGo();

  }
  public function updatedOrderno(){
    $this->OrderNoFound=false;
  }
  public function BtnHeader()
  {
    $this->validate();
    $this->HeadOpen=false;
    $this->HeadDataOpen=true;
    $this->emit('HeadBtnClick',$this->order_no,$this->order_date,$this->jeha_no,$this->OrderSellRadio,$this->stno);
    $this->emitTo('sell.order-sell-detail-edit','TakeParam',$this->order_no,$this->stno);
    $this->emitTo('sell.order-sell-detail-edit','mountdetail',$this->OrderSellRadio,$this->stno,$this->st_name);
  }
  public function ChkOrderNoANdGo(){
    if ($this->order_no) {
      $this->emit('mounttable');
      Config::set('database.connections.other.database', Auth::user()->company);
      $res = sells::find($this->order_no);
      if ($res) {
        $this->jeha_no=$res->jeha;
        $this->stno=$res->place_no;
        $this->order_date=$res->order_date;
        $this->ksm=$res->ksm;
        $this->tot=$res->tot;
        $this->tot1=$res->tot1;
        $this->madfooh=$res->cash;
        $this->notes=$res->notes;

        $this->jeha_name=jeha::find($this->jeha_no)->jeha_name;
        if ($res->sell_type==1){
          $this->OrderSellRadio='Makazen';
          $this->st_name=stores_names::find($this->stno)->st_name;
        } else{
          $this->OrderSellRadio='Salat';
          $this->st_name=halls_names::find($this->stno)->hall_name;
        }
        $this->emitTo('sell.order-sell-table-edit',
          'GetOrderData',$this->order_no,$this->ksm,$this->madfooh,$this->tot1,$this->tot,$this->jeha_no,$this->stno,$this->notes);
        $this->OrderNoFound=true;

      } else $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ');

    }
  }



    public function mounthead(){

        $this->mount();
    }

    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [
            'order_no' => ['required','integer','gt:0', 'exists:other.sells,order_no'],
            'order_date' => ['required','date']
        ];
    }
    protected $messages = [
        'exists' => 'هذا الرقم غير مخزون',
        'required' => 'لا يجوز ترك فراغ',
        'order_date.required'=>'يجب ادخال تاريخ صحيح',
    ];

    public function mount()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        $this->order_no='';
        $this->order_date='';
        $this->stno;
        $this->st_name;
        $this->jeha_no;
        $this->jeha_name;
        $this->jeha_type='1';
        $this->HeadOpen=True;
        $this->HeadDataOpen=false;
    }



    public function render()
    {
        Config::set('database.connections.other.database', Auth::user()->company);

        return view('livewire.sell.order-sell-head-edit');
    }
}

