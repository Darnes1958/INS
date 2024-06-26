<?php

namespace App\Http\Livewire\Stores;

use App\Models\stores\items;
use App\Models\stores\item_type;
use App\Models\stores\item_price_buy;
use App\Models\stores\item_price_sell;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AddItem extends Component
{

    public $item_add;
    public $item_name;
    public $itemtype;
    public $itemtypel;
    public $price_buy;
    public $price_sell;

    protected $listeners = [
        'itemtypeadded','gotoaddonetype','gotoitem'
    ];

    public function gotoitem(){
      $this->emit('gotoadditem','item_add');
    }
    public function resetitem(){

      $this->item_add=items::on(Auth()->user()->company)->max('item_no')+1;
      $this->item_name='';
      $this->itemtype=item_type::on(Auth()->user()->company)->min('type_no');
      $this->itemtypel=item_type::on(Auth()->user()->company)->min('type_no');
      $this->price_sell=0;
      $this->price_buy=0;



    }
    public function OpenSecond(){
        $this->dispatchBrowserEvent('CloseFirst');
        $this->dispatchBrowserEvent('OpenSecond');
    }
    public function CloseSecond(){
        $this->dispatchBrowserEvent('CloseSecond');
        $this->dispatchBrowserEvent('OpenFirst');
        $this->emit('gotonext','itemtype');
    }

    public function gotoaddonetype(){
        $this->emit('gotonext','itemtype');
    }
    public function itemtypeadded($no)
    {
     $this->itemtype=$no;
     $this->itemtypel=$no;
    }
    protected function rules()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        return [
            'item_add' => ['required','integer','gt:0', 'unique:other.items,item_no'],
            'item_name' => ['required', 'unique:other.items,item_name'],
            'itemtype' => ['required','integer','gt:0','exists:other.item_type,type_no'],
            'price_buy' => ['required','numeric','gt:0'],
            'price_sell' => ['required','numeric','gt:0'],
        ];
    }
    protected $messages = [
        'required' => 'لا يجوز ترك فراغ',
        'item_name.unique' => 'هذا الاسم مخزون مسبقا',
        'unique' => 'هذا الرقم مخزون مسبقا',
    ];

    public function updatedItemtypel(){
        $this->itemtype=$this->itemtypel;
        $this->emit('gotonext','itemtype');
    }
    public function updatedItemtype(){
        $this->itemtypel=$this->itemtype;
    }

    public function SaveItem(){
        $this->validate();
        DB::connection(Auth()->user()->company)->beginTransaction();
        try {
              DB::connection(Auth()->user()->company)->table('items')->insert([
                'item_no' => $this->item_add,
                'item_name' => $this->item_name,
                'item_type' => $this->itemtype,
                'price_buy' => $this->price_buy,
                'price_sell' => $this->price_sell,
                'price_cost' => $this->price_buy,
                'raseed' => 0,
                'available' => 1
              ]);
              DB::connection(Auth()->user()->company)->table('item_price_buy')->insert([
                'item_no' => $this->item_add,
                'price_type' => 1,
                'price' => $this->price_buy,
              ]);
              DB::connection(Auth()->user()->company)->table('item_price_sell')->insert([
                'item_no' => $this->item_add,
                'price_type' => 1,
                'price' => $this->price_sell,
              ]);

            DB::connection(Auth()->user()->company)->commit();

            } catch (\Exception $e) {
            DB::connection(Auth()->user()->company)->rollBack();
                   // something went wrong
                                    }
        $this->resetitem();
        $this->emitTo('stores.item-select','RefreshSelectItem');
        $this->emit('gotonext','item_no');
       // $this->dispatchBrowserEvent('CloseFirst');
    }
    public function mount()
    {
     $this->resetitem();

    }
    public function render()
    {
        return view('livewire.stores.add-item',['item_types'=>item_type::on(Auth()->user()->company)->get(),]);
    }
}
