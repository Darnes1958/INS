<?php

namespace App\Http\Livewire\Buy;

use App\Models\jeha\jeha;
use App\Models\stores\items;
use App\Models\stores\stores;
use App\Models\stores\stores_names;
use App\Models\buy\buys;
use Livewire\Component;

class OrderBuyAdd extends Component
{
    public $order_no;
    public $order_date;

    protected $rules = [
        'order_no' => 'required',
        'order_date' => 'required',
    ];
    public function BtnHeader()
    {
        $this->validate();
        $this->emit('head-btn-click','order_no');

    }

    public $suppliergo;


    public function updatedSuppliergo()
    {

        $this->emit('gotonext', 'supplier_id');
    }

    public $store;


    public function updatedStore()
    {
        $this->emit('gotonext', 'store_id');
    }


    public function render()
    {
        return view('livewire.buy.order-buy-add',[
            'jeha'=>jeha::where('jeha_type',2)->where('available',1)->get(),
            'stores'=>stores::where('raseed','>',0)->get(),
            'stores_names'=>stores_names::all(),
            'items'=>items::where('raseed','>',0)->get(),
            'date' => date('Y-m-d'),
            'wid' => buys::max('order_no')+1,


        ]);



    }
}
