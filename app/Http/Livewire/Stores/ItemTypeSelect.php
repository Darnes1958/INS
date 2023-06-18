<?php

namespace App\Http\Livewire\Stores;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ItemTypeSelect extends Component
{
  public $TypeNo;
  public $TypeName;
  public $TypeList;


  protected $listeners = [
    'TakeTypeNo',
  ];


  public function TakeTypeNo($typeno){
    $this->TypeNo = $typeno;
  }
  public function hydrate(){
    $this->emit('itemtype-change-event');
  }

    public function render()
    {



        $this->TypeList=DB::connection(Auth()->user()->company)->table('item_type')
          ->get();

        return view('livewire.stores.item-type-select',$this->TypeList);
    }
}
