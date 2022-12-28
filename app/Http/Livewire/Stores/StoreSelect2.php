<?php

namespace App\Http\Livewire\Stores;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StoreSelect2 extends Component
{
  public $PlaceNo2;
  public $PlaceName2;
  public $PlaceList2;
  public $Table='Makazen';

  protected $listeners = [
    'TakePlaceNo2',
  ];

  public function TakePlaceNo2($placeno){
    $this->PlaceNo2 = $placeno;
  }
  public function mount($table){
    $this->Table=$table;
  }
  public function hydrate(){
    $this->emit('place2-change-event');
  }

  public function render()
  {
    Config::set('database.connections.other.database', Auth::user()->company);
    if ($this->Table=='Makazen') {
      $this->PlaceList2=DB::connection(Auth()->user()->company)->table('stores_names')
        ->selectRaw('st_no as place_no,st_name as place_name')
        ->get();
    }
    if ($this->Table=='Salat') {
      $this->PlaceList2=DB::connection(Auth()->user()->company)->table('halls_names')
        ->selectRaw('hall_no as place_no,hall_name as place_name')
        ->get();
    }
    return view('livewire.stores.store-select2',$this->PlaceList2);
  }
}
