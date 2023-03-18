<?php

namespace App\Http\Livewire\Buy;

use App\Models\buy\buy_tran;
use App\Models\buy\buys;
use App\Models\buy\rep_buy_tran;
use App\Models\jeha\jeha;
use App\Models\stores\stores_names;
use App\Models\Tar\tar_buy_view;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;


use Barryvdh\DomPDF\Facade\Pdf;
use ArPHP\I18N\Arabic;


class RepOrderBuy extends Component
{

  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $orderno=0;
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
  public $TotCharge=0;

  public $TheOrderListSelected;
  public $OrderGeted=false;
  public $has_tar=false;

  public function printView(){
    $orderdetail=rep_buy_tran::on(Auth()->user()->company)->where('order_no',$this->orderno)->get();
     $pdfContent = PDF::loadView('PrnView.buy.rep-order-buy',
         ['orderdetail'=>$orderdetail,'order_no'=>$this->orderno,'order_date'=>$this->order_date])->output();

  //    $pdfContent = PDF::loadView('PrnView.buy.rep-order-buy',compact(
  //               'orderdetail'));


      return response()->streamDownload(
         fn () => print($pdfContent),"filename.pdf");

  }

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
  public function updatedOrderno(){
      $this->OrderGeted=false;
  }
  public function ChkOrderNoAndGo(){
      $this->OrderGeted=false;
    if ($this->orderno) {

        $res=buys::on(Auth()->user()->company)->find($this->orderno);

        if ($res) {
          $this->has_tar=buy_tran::where('order_no',$this->orderno)->where('tarjeeh',1)->exists();
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
          $this->TotCharge=$res->tot_charges;

          $this->jeha_name=jeha::on(Auth()->user()->company)->find($this->jeha_no)->jeha_name;
          $this->place_name=stores_names::on(Auth()->user()->company)->find($this->place_no)->st_name;
          $this->OrderGeted=True;

        } else {$this->dispatchBrowserEvent('mmsg','هذا الرقم غير مخزون');$this->clearData();}
  }}

  public function render()
    {

      return view('livewire.buy.rep-order-buy',[
        'orderdetail'=>rep_buy_tran::on(Auth()->user()->company)
            ->where('order_no',$this->orderno)->paginate(10),
        'chargedetail'=>DB::connection(Auth()->user()->company)->table('charges_buy_view')
              ->where('order_no',$this->orderno)->paginate(5),
        'TarList'=>tar_buy_view::where('order_no',$this->orderno)->paginate(5),
      ]);
    }
}
