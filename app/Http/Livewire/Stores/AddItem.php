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

    public $item_no;
    public $item_name;
    public $itemtype;
    public $itemtypel;
    public $price_buy;
    public $price_sell;

    protected $listeners = [
        'itemtypeadded','gotoaddonetype'
    ];
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
            'item_no' => ['required','integer','gt:0', 'unique:other.items,item_no'],
            'item_name' => ['required'],
            'itemtype' => ['integer','integer','gt:0','exists:other.item_type,type_no'],
            'price_buy' => ['required','numeric','gt:0'],
            'price_sell' => ['required','numeric','gt:0'],
        ];
    }
    public function updatedItemtypel(){
        $this->itemtype=$this->itemtypel;
        $this->emit('gotonext','itemtype');
    }
    public function updatedItemtype(){

        $this->itemtypel=$this->itemtype;

    }


    public function SaveItem(){
        $this->validate();

        Config::set('database.connections.other.database', Auth::user()->company);
        try {
              DB::connection('other')->table('items')->insert([
                'item_no' => $this->item_no,
                'item_name' => $this->item_name,
                'item_type' => $this->itemtype,
                'price_buy' => $this->price_buy,
                'price_sell' => $this->price_sell,
                'raseed' => 0,
                'available' => 1

              ]);
              DB::connection('other')->table('item_price_buy')->insert([
                'item_no' => $this->item_no,
                'price_type' => 1,
                'price' => $this->price_buy,
              ]);
              DB::connection('other')->table('item_price_sell')->insert([
                'item_no' => $this->item_no,
                'price_type' => 1,
                'price' => $this->price_sell,
              ]);

             DB::commit();

            } catch (\Exception $e) {
                   DB::rollback();
                   // something went wrong
                                    }


        $this->dispatchBrowserEvent('CloseFirst');
    }
    public function mount()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        $this->item_no=items::max('item_no')+1;
        $this->itemtype=1;
        $this->itemtypel=1;
        $this->price_sell=0;
        $this->price_buy=0;

    }
    public function render()
    {
        return view('livewire.stores.add-item',['item_types'=>item_type::all(),]);
    }
}
