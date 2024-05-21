<?php

namespace App\Http\Livewire\Stores;

use App\Models\stores\stores;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;
use App\Models\stores\items;
use Illuminate\Support\Facades\DB;

class ItemSelect2 extends Component
{
  public $ItemListNo2;
  public $ItemName;
  public $ItemList;
  public $PlaceSelectType2;
  public $PlaceToSelect2;
  protected $listeners = [
    'itemfound','B_RefreshSelectItem2','RefreshSelectItem2' => '$refresh','TakeItemNo2'
  ];

  public function B_RefreshSelectItem2($PST,$PTS){
   $this->PlaceSelectType2=$PST;
   $this->PlaceToSelect2=$PTS;
   $this->render();
   }
  public function TakeItemNo2($item_no){

    $this->ItemListNo2=$item_no;
  }
  public function jehafound($wj,$wn){
    if(!is_null($wj)) {
      $this->ItemListNo2 = $wj;
      $this->ItemName = $wn;
    }
  }

  public function mount($placeSelectType='items',$placeToselect=1){
    $this->PlaceSelectType2=$placeSelectType;
    $this->PlaceToSelect2=$placeToselect;
  }
  public function hydrate(){

    $this->emit('item2-change-event');
  }
    public function render()
    {

        if ($this->PlaceSelectType2=='items') {

        $this->ItemList=DB::connection(Auth()->user()->company)->table('items')
          ->select('item_no', 'raseed', 'item_name')
          ->where('available',1)
          ->get();}
        if ($this->PlaceSelectType2=='Makazen') {
            $this->ItemList=DB::connection(Auth()->user()->company)->table('stores')
                ->join('items', 'stores.item_no', '=', 'items.item_no')
                ->select('stores.item_no', 'stores.raseed', 'items.item_name')
                ->where('stores.st_no',$this->PlaceToSelect2)
                ->where('stores.raseed','>',0)
                ->get();}
        if ($this->PlaceSelectType2=='Salat') {
            $this->ItemList=DB::connection(Auth()->user()->company)->table('halls')
                ->join('items', 'halls.item_no', '=', 'items.item_no')
                ->select('halls.item_no', 'halls.raseed', 'items.item_name')
                ->where('halls.hall_no',$this->PlaceToSelect2)
                ->where('halls.raseed','>',0)
                ->get();  }

        return view('livewire.stores.item-select2',$this->ItemList);
    }
}
