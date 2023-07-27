<?php

namespace App\Http\Livewire\Stores;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StoreSelect3 extends Component
{
  public $PlaceNo3;
  public $PlaceName3;
  public $PlaceList3;
  public $Table='Makazen';

  protected $listeners = [
    'TakePlaceNo3','ResetYou',
  ];
  public function ResetYou($table){
      $this->Table=$table;

  }

  public function TakePlaceNo3($placeno){
    $this->PlaceNo3 = $placeno;
  }
  public function mount($table){
    $this->Table=$table;
  }
  public function hydrate(){
    $this->emit('place3-change-event');
  }

    public function render()
    {

      if ($this->Table=='Makazen') {
        $this->PlaceList3=DB::connection(Auth()->user()->company)->table('stores_names')
         ->selectRaw('st_no as place_no,st_name as place_name')
         ->get();
      }
      if ($this->Table=='Salat') {
        $this->PlaceList3=DB::connection(Auth()->user()->company)->table('halls_names')
          ->selectRaw('hall_no as place_no,hall_name as place_name')
          ->get();
      }
        return view('livewire.stores.store-select3',$this->PlaceList3);
    }
}
