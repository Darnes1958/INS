<?php

namespace App\Http\Livewire\Buy;

use App\Models\buy\buy_tran;
use App\Models\buy\buys;
use App\Models\buy\charge_by;
use App\Models\buy\charge_type;
use App\Models\buy\charges_buy;
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

  public $Charge_Tot=0;
  public $ChargeDetail=[];

    protected $listeners = [
        'mounthead','jehaadded','DoDelete','TakeCharge',
    ];
  public function TakeCharge($charge){
    $this->Charge_Tot=$charge;
  }
  public function OpenCharge(){
    $this->emitTo('buy.charge-buy','open',true);
    $this->emitTo('buy.order-buy-table-edit','open',false);
  }
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
          $this->jeha = $res->jeha;
          $this->stno = $res->place_no;
          $this->order_date = $res->order_date;
          $this->ksm = $res->ksm;
          $this->tot = $res->tot;
          $this->tot1 = $res->tot1;
          $this->madfooh = $res->cash;
          $this->notes = $res->notes;

          $this->jeha_name = jeha::on(Auth()->user()->company)->find($this->jeha)->jeha_name;
          $this->st_name = stores_names::on(Auth()->user()->company)->find($this->stno)->st_name;

          $this->Charge_Tot= $res->tot_charges;
          if ($this->Charge_Tot!=0){
            $chrg=charges_buy::on(Auth::user()->company)->where('order_no',$this->orderno)->get();
            foreach ($chrg as $item){
              $this->ChargeDetail[] =
                ['no' => $item->charge_by,
                  'name' => charge_by::on(Auth::user()->company)->find($item->charge_by)->name,
                  'type_no'=>$item->charge_type,
                  'type_name'=>charge_type::on(Auth::user()->company)->find($item->charge_type)->type_name,
                  'val'=>$item->val,
                ];
            }

          }
          $this->emitTo('buy.charge-buy','TakeChargeEdit',$this->ChargeDetail);

          $this->emit('GetOrderData',$this->orderno,$this->ksm,$this->madfooh,$this->tot1,$this->tot,$this->jeha,$this->stno,$this->notes);
          $this->OrderNoFound=true;

        } else $this->dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ');

        }
    }
    protected function rules()
    {

        return [

            'order_date' => ['required','date']
        ];
    }
    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',

        'order_date.required'=>'يجب ادخال تاريخ صحيح',
    ];


    public function BtnHeader()
    {
        $this->validate();
        $this->HeadOpen=false;
        $this->HeadDataOpen=true;
        $this->emitTo('buy.charge-buy','open',false);
        $this->emitTo('buy.order-buy-table-edit','open',true);
        $this->emitTo('buy.order-buy-table-edit','TakeChargeEdit',$this->ChargeDetail,$this->Charge_Tot);
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
        $this->dispatchBrowserEvent('mmsg', 'الصنف رقم :  '.$item->item_no.'  سيصبح رصيده فالمخزن اقل من الصفر');
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
      $this->ChargeDetail=[];
      $this->ChargeDetail=[
        ['no'=>'0','name'=>'',
          'type_no'=>'0','type_name'=>'','val'=>'0', ]
      ];
      $this->orderno='';
      $this->order_date='';
      $this->jeha='';
      $this->stno='';
      $this->HeadOpen=true;
      $this->emitTo('buy.charge-buy','open',false);
      $this->emitTo('buy.order-buy-table-edit','open',true);
      $this->emit('gotonext','orderno');
    }
    public function render()
    {

        return view('livewire.buy.order-buy-head-edit');
    }
}
