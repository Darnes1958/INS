<?php

namespace App\Http\Livewire\Buy;

use App\Models\buy\buy_tran_work_view;
use App\Models\buy\buys;
use App\Models\buy\rep_buy_tran;
use App\Models\jeha\jeha;
use App\Models\stores\halls_names;
use App\Models\stores\items;
use App\Models\stores\stores_names;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class OrderBuy extends Component
{
    public $ToSal_L;
    public $ToSal=false;

    public $order_no;
    public $order_date;
    public $jeha_no;
    public $jeha_type;
    public $st_no;
    public $st_nol;
    public $st_name;
    public $jeha_name;
    public $Charge_Tot=0;
    public $ItemToEdit;
    public $ShowEditItem=false;
    public $stno=1;
    public $item_no;
    public $item_name;
    public $st_raseed;
    public $raseed;
    public $quant;
    public $price;
    public $ksm;
    public $madfooh;
    public $tot1;
    public $tot;
    public $orderdetail=[];


    public $notes;
    public $TheDelete;
    public $OrderChanged=false;
    public $ChargeDetail=[];
    public $ChargeTot;
    public $IsSave=false;

    public $ItemGeted=false;
    public $TheItemIsSelected;

    public $TheJehaIsSelected;

    public function updated($field)
    {
        if ($field=='st_nol') {
            $this->st_no=$this->st_nol;
            $this->emit('gotonext', 'st_no');
        }
        if ($field=='st_no')
            $this->st_nol=$this->st_no;


        if ($field=='TheJehaIsSelected'){
            $this->TheJehaIsSelected=0;
            $this->emit('gotonext','st_no');
        }
        if ($field=='jeha_no'){
            $this->jeha_name='';
            $this->jeha_type=0;
            if ($this->jeha_no!=null) {
              $result = jeha::where('jeha_type',2)->where('jeha_no',$this->jeha_no)->first();
                if ($result) {  $this->jeha_name=$result->jeha_name;
                    $this->jeha_type=$result->jeha_type;
                }}
        }
    }
    public function DoEditItem(){
        $this->ShowEditItem=true;
        $this->ItemToEdit=$this->item_name;

        $this->emit('gotonext','ItemToEdit');

    }
    public function SaveItem(){
        if ($this->ItemToEdit!=null){
            items::find($this->item)->update(['item_name'=>$this->ItemToEdit]);
            $this->item_name = $this->ItemToEdit;
            $this->ShowEditItem = false;
            $this->emit('gotonext','quant');
        }
    }

    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [
            'order_no' => ['required','integer','gt:0', 'unique:other.buys,order_no'],
            'order_date' => ['required','date'],
            'jeha_type' => ['integer','size:2'],
            'st_no' => ['required','integer','gt:0', 'exists:other.stores_names,st_no'],
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

        $this->order_no=buys::on(Auth()->user()->company)->max('order_no')+1;
        $this->order_date=date('Y-m-d');
        $this->st_no='1';
        $this->st_nol=1;
        $this->st_name='المخزن الرئيسي';
        $this->jeha_no='2';
        $this->jeha_name='مشتريات عامة';
        $this->jeha_type='2';

        $this->Charge_Tot=0;


    }

    public function OpenModal(){
        $this->emitTo('jeha.add-supp','WithJehaType',2);
        $this->dispatchBrowserEvent('OpenModal');
    }
    public function CloseModal(){
        $this->dispatchBrowserEvent('CloseModal');
    }
    public function OpenCharge(){

        $this->emitTo('buy.charge-buy','open',true);
        $this->emitTo('buy.order-buy-table','open',false);
    }
    public function render()
    {
        return view('livewire.buy.order-buy',[
            'orderdetail'=>buy_tran_work_view::where('emp',Auth::user()->empno)->get(),
            'stores_names'=>stores_names::get(),
            'halls_names'=>halls_names::get(),
        ]);
    }
}
