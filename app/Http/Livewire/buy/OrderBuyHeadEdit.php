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
use Livewire\Component;

class OrderBuyHeadEdit extends Component
{
    public $order_no;
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


    public $HeadOpen;
    public $HeadDataOpen;

    protected $listeners = [
        'mounthead','jehaadded',
    ];

    public function ChkOrderNoAndGo(){
      if ($this->order_no) {
        Config::set('database.connections.other.database', Auth::user()->company);
        $res = buys::find($this->order_no);
        if ($res) {
          $this->jeha=$res->jeha;
          $this->stno=$res->place_no;
          $this->order_date=$res->order_date;
          $this->ksm=$res->ksm;
          $this->tot=$res->tot;
          $this->tot1=$res->tot1;
          $this->madfooh=$res->cash;
          $this->notes=$res->notes;

          $this->jeha_name=jeha::find($this->jeha)->jeha_name;
          $this->st_name=stores_names::find($this->stno)->st_name;
          $this->emit('GetOrderData',$this->order_no,$this->ksm,$this->madfooh,$this->tot1,$this->tot,$this->jeha,$this->stno,$this->notes);


        } else dispatchBrowserEvent('mmsg', 'هذا الرقم غير مخزون ');

        }
    }
    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [
            'order_no' => ['required','integer','gt:0', 'exists:other.buys,order_no'],
            'order_date' => 'required',
        ];
    }
    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',
        'exists' => 'هذا الرقم غير مخزون',
        'order_date.required'=>'يجب ادخال تاريخ صحيح',
    ];


    public function BtnHeader()
    {
        $this->validate();
        $this->HeadOpen=false;
        $this->HeadDataOpen=true;
        $this->emit('HeadBtnClick',$this->order_no,$this->order_date,$this->jeha,$this->stno);
        $this->emit('mountdetail');
    }


    public function render()
    {

        return view('livewire.buy.order-buy-head-edit');
    }
}
