<?php

namespace App\Http\Livewire\Sell;

use App\Models\jeha\jeha;
use App\Models\sell\price_type;
use App\Models\sell\rep_sell_tran;
use App\Models\sell\sells;
use App\Models\stores\halls_names;
use App\Models\stores\stores_names;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;

class RepOrderSell extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $orderno2=0;
  public $order_no;
  public $order_date;
  public $jeha_no;
  public $jeha_type;
  public $place_no=1;
  public $place_type;
  public $place_name;
  public $jeha_name;
  public $price_type;
  public $type_name;

  public $tot1;
  public $ksm;
  public $tot;
  public $cash;
  public $not_cash;
  public $notes;

  public $TheOrderListSelected;

  public $DoNotShowOrder=false;
  protected $listeners = [
    'TakeOrderNo',
    ];

  public function TakeOrderNo($order_no){
    $this->order_no=$order_no;
    $this->DoNotShowOrder=true;
    $this->ChkOrderNoAndGo();
  }
  public function updatedTheOrderListSelected(){
    $this->TheOrderListSelected=0;
    $this->ChkOrderNoAndGo();
  }
  public function clearData(){
    $this->order_date='';
    $this->jeha_no='';
    $this->place_no='';
    $this->place_type='';
    $this->price_type='';
    $this->tot1='';
    $this->tot='';
    $this->ksm='';
    $this->cash='';
    $this->not_cash='';
    $this->notes='';
    $this->place_name='';
    $this->type_name='';
    $this->jeha_name='';

  }
  public function ChkOrderNoAndGo(){
    if ($this->order_no) {

      $res=sells::where('order_no',$this->order_no)->first();

    if ($res) {
      $this->orderno2=$this->order_no;

      $this->order_date=$res->order_date;
      $this->jeha_no=$res->jeha;
      $this->place_no=$res->place_no;
      $this->place_type=$res->sell_type;
      $this->price_type=$res->price_type;
      $this->tot1=$res->tot1;
      $this->tot=$res->tot;
      $this->ksm=$res->ksm;
      $this->cash=$res->cash;
      $this->not_cash=$res->not_cash;
      $this->notes=$res->notes;

      $this->jeha_name=jeha::on(Auth()->user()->company)->find($this->jeha_no)->jeha_name;
      if ($this->place_type==1){ $this->place_name=stores_names::on(Auth()->user()->company)->find($this->place_no)->st_name;}
      if ($this->place_type==2){ $this->place_name=halls_names::on(Auth()->user()->company)->find($this->place_no)->hall_name;}
      $this->type_name=price_type::on(Auth()->user()->company)->find($this->price_type)->type_name;
    } else {$this->order_no2=0; $this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');$this->clearData();}
  }}

  public function render()
    {

      return view('livewire.sell.rep-order-sell',[
        'orderdetail'=>rep_sell_tran::on(Auth()->user()->company)->where('order_no',$this->orderno2)->paginate(15)
      ]);
    }
}
