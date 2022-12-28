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
  public $ItemListNo;
  public $ItemName;
  public $ItemList;
  public $PlaceSelectType;
  public $PlaceToSelect;
  protected $listeners = [
    'itemfound','B_RefreshSelectItem','RefreshSelectItem => $refresh','TakeItemNo'
  ];

  public function B_RefreshSelectItem($PST,$PTS){
   $this->PlaceSelectType=$PST;
   $this->PlaceToSelect=$PTS;

   $this->render();
   }
  public function TakeItemNo($item_no){
    $this->ItemListNo=$item_no;
  }
  public function jehafound($wj,$wn){
    if(!is_null($wj)) {
      $this->ItemListNo = $wj;
      $this->ItemName = $wn;
    }
  }

  public function mount($placeSelectType='items',$placeToselect=1){
    $this->PlaceSelectType=$placeSelectType;
    $this->PlaceToSelect=$placeToselect;
  }
  public function hydrate(){

    $this->emit('item-change-event');
  }
    public function render()
    {

        if ($this->PlaceSelectType=='items') {

        $this->ItemList=DB::connection(Auth()->user()->company)->table('items')
          ->select('item_no', 'raseed', 'item_name')
          ->where('available',1)
          ->get();}
        if ($this->PlaceSelectType=='Makazen') {
            $this->ItemList=DB::connection(Auth()->user()->company)->table('stores')
                ->join('items', 'stores.item_no', '=', 'items.item_no')
                ->select('stores.item_no', 'stores.raseed', 'items.item_name')
                ->where('stores.st_no',$this->PlaceToSelect)
                ->where('stores.raseed','>',0)
                ->get();}
        if ($this->PlaceSelectType=='Salat') {
            $this->ItemList=DB::connection(Auth()->user()->company)->table('halls')
                ->join('items', 'halls.item_no', '=', 'items.item_no')
                ->select('halls.item_no', 'halls.raseed', 'items.item_name')
                ->where('halls.hall_no',$this->PlaceToSelect)
                ->where('halls.raseed','>',0)
                ->get();  }

        return view('livewire.stores.item-select',$this->ItemList);
    }
}
