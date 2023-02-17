<?php

namespace App\Http\Livewire\Masr;

use App\Models\masr\MasTypes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MasrTypeSelect extends Component
{
  public $MasTypeNo;

  public $TableList;


  protected $listeners = [
    'TakeMasTypeNo','refreshComponent' => '$refresh'
  ];

  public function TakeMasTypeNo($wo){

    if(!is_null($wo)) {
      $this->MasTypeNo = $wo;


    }
  }

  public function hydrate(){
    $this->emit('mastype-change-event');
  }
    public function render()
    {
      $this->TableList=MasTypes::get();
        return view('livewire.masr.masr-type-select',$this->TableList);
    }
}
