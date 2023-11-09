<?php

namespace App\Http\Livewire\Aksat;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class NameSelect extends Component
{
  public $Acc;
  public $name;
  public $AccList;


  protected $listeners = [
    'TakeAcc',
  ];

  public function TakeAcc($wj,$wn){

    if(!is_null($wj)) {
      $this->Acc = $wj;
      $this->name = $wn;

    }
  }

  public function hydrate()
  {
    $this->emit('Acc-change-event');
  }
    public function render()
    {
      $this->AccList=DB::connection(Auth()->user()->company)->table('main')->get();
      return view('livewire.aksat.name-select',$this->AccList);

    }
}
