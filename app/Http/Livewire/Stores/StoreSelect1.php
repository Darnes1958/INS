<?php

namespace App\Http\Livewire\Stores;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class StoreSelect1 extends Component
{
  public $PlaceNo1;
  public $PlaceName1;
  public $PlaceList1;
  public $Table='Makazen';

  protected $listeners = [
    'TakePlaceNo1','ResetYou',
  ];
  public function ResetYou($table){
      $this->Table=$table;

  }

  public function TakePlaceNo1($placeno){
    $this->PlaceNo1 = $placeno;
  }
  public function mount($table){
    $this->Table=$table;
  }
  public function hydrate(){
    $this->emit('place1-change-event');
  }

    public function render()
    {
      Config::set('database.connections.other.database', Auth::user()->company);
      if ($this->Table=='Makazen') {
        $this->PlaceList1=DB::connection(Auth()->user()->company)->table('stores_names')
         ->selectRaw('st_no as place_no,st_name as place_name')
         ->get();
      }
      if ($this->Table=='Salat') {
        $this->PlaceList1=DB::connection(Auth()->user()->company)->table('halls_names')
          ->selectRaw('hall_no as place_no,hall_name as place_name')
          ->get();
      }
        return view('livewire.stores.store-select1',$this->PlaceList1);
    }
}
