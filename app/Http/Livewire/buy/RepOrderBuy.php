<?php

namespace App\Http\Livewire\Buy;

use App\Models\buy\buys;
use App\Models\buy\rep_buy_tran;
use App\Models\jeha\jeha;
use App\Models\stores\stores_names;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use Livewire\WithPagination;

class RepOrderBuy extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $order_no=0;
  public $order_date;
  public $jeha_no;
  public $jeha_type;
  public $place_no=1;

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

  public function updatedTheOrderListSelected(){
    $this->TheOrderListSelected=0;
    $this->ChkOrderNoAndGo();
  }
  public function clearData(){
    $this->order_date='';
    $this->jeha_no='';
    $this->place_no='';
    $this->price_type='';
    $this->tot1='';
    $this->tot='';
    $this->ksm='';
    $this->cash='';
    $this->not_cash='';
    $this->notes='';
    $this->place_name='';

    $this->jeha_name='';

  }
  public function ChkOrderNoAndGo(){
    if ($this->order_no) {

      $res=buys::on(Auth()->user()->company)->find($this->order_no);

    if ($res) {
      $this->order_date=$res->order_date;
      $this->jeha_no=$res->jeha;
      $this->place_no=$res->place_no;
      $this->price_type=$res->price_type;
      $this->tot1=$res->tot1;
      $this->tot=$res->tot;
      $this->ksm=$res->ksm;
      $this->cash=$res->cash;
      $this->not_cash=$res->not_cash;
      $this->notes=$res->notes;

      $this->jeha_name=jeha::on(Auth()->user()->company)->find($this->jeha_no)->jeha_name;
      $this->place_name=stores_names::on(Auth()->user()->company)->find($this->place_no)->st_name;

    } else {$this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');$this->clearData();}
  }}

  public function render()
    {

      return view('livewire.buy.rep-order-buy',[
        'orderdetail'=>rep_buy_tran::on(Auth()->user()->company)->where('order_no',$this->order_no)->paginate(15)
      ]);
    }
}
