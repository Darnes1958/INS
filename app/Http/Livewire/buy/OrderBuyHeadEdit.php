<?php

namespace App\Http\Livewire\Buy;

use App\Models\buy\buy_tran;
use App\Models\buy\buys;
use App\Models\jeha\jeha;
use App\Models\stores\items;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderBuyHeadEdit extends Component
{
    public $orderno;
    public $order_date;
    public $jeha;
    public $stno;
    public $st_name;
    public $jeha_name;

    public $ksm;
    public $madfooh;
    public $tot1;
    public $tot;
    public $orderdetail=[];
    public $notes;

    public $OrderNoFound=false;


    public $HeadOpen=true;
    public $HeadDataOpen=false;
    public $TheOrderListSelected;

    public $Good=true;

    protected $listeners = [
        'mounthead','jehaadded','DoDelete'
    ];
  public function updatedTheOrderListSelected(){
    $this->TheOrderListSelected=0;
    $this->ChkOrderNoAndGo();
  }
  public function mounthead(){

    $this->mount();
    $this->OrderNoFound=false;
    $this->emitTo('buy.order-buy-detail-edit','dismountdetail');
    $this->emit('gotonext','orderno');
  }
    public function updatedOrderno(){
        $this->OrderNoFound=false;
    }
    public function ChkOrderNoAndGo(){
      if ($this->orderno) {
        $this->emit('mounttable');

        $res = buys::on(Auth()->user()->company)->find($this->orderno);
        if ($res) {
          $this->jeha=$res->jeha;
          $this->stno=$res->place_no;
          $this->order_date=$res->order_date;
          $this->ksm=$res->ksm;
          $this->tot=$res->tot;
          $this->tot1=$res->tot1;
          $this->madfooh=$res->cash;
          $this->notes=$res->notes;

          $this->jeha_name=jeha::on(Auth()->user()->company)->find($this->jeha)->jeha_name;
          $this->st_name=stores_names::on(Auth()->user()->company)->find($this->stno)->st_name;
          $this->emit('GetOrderData',$this->orderno,$this->ksm,$this->madfooh,$this->tot1,$this->tot,$this->jeha,$this->stno,$this->notes);
          $this->OrderNoFound=true;

        } else $this->dispatchBrowserEvent('mmsg', '?????? ?????????? ?????? ?????????? ');

        }
    }
    protected function rules()
    {

        return [

            'order_date' => ['required','date']
        ];
    }
    protected $messages = [
        'required' => '???? ???????? ?????? ????????',

        'order_date.required'=>'?????? ?????????? ?????????? ????????',
    ];


    public function BtnHeader()
    {
        $this->validate();
        $this->HeadOpen=false;
        $this->HeadDataOpen=true;
        $this->emit('HeadBtnClick',$this->orderno,$this->order_date,$this->jeha,$this->stno);
        $this->emitTo('buy.order-buy-detail-edit','TakeParam',$this->orderno,$this->stno);
        $this->emitTo('buy.order-buy-detail-edit','mountdetail');
    }
  public function BtnHeaderDel()
  {
    $this->dispatchBrowserEvent('dodelete');
  }
  public function DoDelete(){


    $this->Good=true;
    $res=buy_tran::on(Auth()->user()->company)->where('order_no',$this->orderno)->get();
    foreach ($res as $item){
      $st_raseed=stores::on(Auth()->user()->company)->where('st_no',$this->stno)->where('item_no',$item->item_no)->first();
      if ($st_raseed && $item->quant>$st_raseed->raseed){
        $this->dispatchBrowserEvent('mmsg', '?????????? ?????? :  '.$item->item_no.'  ?????????? ?????????? ?????????????? ?????? ???? ??????????');
        $this->Good=false;
        break;
      }
    }
    if ($this->Good){
    DB::connection(Auth()->user()->company)->beginTransaction();
    try {
      buy_tran::on(Auth()->user()->company)->where('order_no',$this->orderno)->delete();
      buys::on(Auth()->user()->company)->where('order_no',$this->orderno)->delete();
      DB::connection(Auth()->user()->company)->commit();
      $this->emitTo('buy.buy-select','refreshComponent');
      $this->emit('mounttable');

      $this->emitTo('buy.order-buy-detail-edit','dismountdetail');
      $this->emitSelf('mounthead');
    } catch (\Exception $e) {
      DB::connection(Auth()->user()->company)->rollback();

    }}

  }
    public function mount(){
      $this->orderno='';
      $this->order_date='';
      $this->jeha='';
      $this->stno='';
      $this->HeadOpen=true;
      $this->emit('gotonext','orderno');
    }
    public function render()
    {

        return view('livewire.buy.order-buy-head-edit');
    }
}
