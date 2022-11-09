<?php

namespace App\Http\Livewire\Stores;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use App\Models\stores\items;

class ItemSelect extends Component
{
  public $ItemNo;
  public $ItemName;
  public $ItemList;

  protected $listeners = [
    'itemfound',
  ];

  public function jehafound($wj,$wn){

    if(!is_null($wj)) {
      $this->ItemNo = $wj;
      $this->ItemName = $wn;
    }
  }

  public function hydrate(){

    $this->emit('item-change-event');
  }
    public function render()
    {
        Config::set('database.connections.other.database', Auth::user()->company);
        $this->ItemList=items::where('available',1)->get();
        return view('livewire.stores.item-select',$this->ItemList);
    }
}
