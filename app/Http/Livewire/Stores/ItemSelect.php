<?php

namespace App\Http\Livewire\Stores;

use App\Models\stores\stores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use App\Models\stores\items;
use Illuminate\Support\Facades\DB;

class ItemSelect extends Component
{
  public $ItemNo;
  public $ItemName;
  public $ItemList;
  public $PlaceSelectType='items';
  public $PlaceToselect=1;
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
      info('before');
        Config::set('database.connections.other.database', Auth::user()->company);
        if ($this->PlaceSelectType=='items') {info('yes'); $this->ItemList=items::where('available',1)->get();}
        if ($this->PlaceSelectType=='Makazen') {
          DB::connection('other')->table('stores')
            ->join('items', 'stores.item_no', '=', 'items.item_no')
            ->select('stores.item_no', 'stores.raseed', 'items.item_name')
            ->where('stores.st_no',$this->PlaceToselect)
            ->get();}
        if ($this->PlaceSelectType=='Salat') {
         DB::connection('other')->table('halls')
          ->join('items', 'halls.item_no', '=', 'items.item_no')
          ->select('halls.item_no', 'halls.raseed', 'items.item_name')
          ->where('halls.hall_no',$this->PlaceToselect)
          ->get();}


        return view('livewire.stores.item-select',$this->ItemList);
    }
}
