<?php

namespace App\Http\Livewire\Aksat;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PlaceSelect extends Component
{
  public $PlaceNo;
  public $PlaceName;
  public $PlaceList;


  protected $listeners = [
    'TakePlaceNo',
  ];

  public function TakePlaceNo($wj,$wn){

    if(!is_null($wj)) {
      $this->PlaceNo = $wj;
      $this->PlaceName = $wn;

    }
  }

  public function hydrate()
  {
    $this->emit('place-change-event');
  }

    public function render()
    {
      Config::set('database.connections.other.database', Auth::user()->company);
      $this->PlaceList=DB::connection('other')->table('place')->get();
        return view('livewire.aksat.place-select',$this->PlaceList);
    }
}
