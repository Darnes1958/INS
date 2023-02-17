<?php

namespace App\Http\Livewire\Masr;

use App\Models\masr\MasCenters;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MasrCenterSelect extends Component
{
  public $CenterNo;

  public $TableList;


  protected $listeners = [
    'TakeCenterNo','refreshComponent' => '$refresh'
  ];

  public function TakeCenterNo($wo){

    if(!is_null($wo)) {
      $this->CenterNo = $wo;


    }
  }

  public function hydrate(){
    $this->emit('center-change-event');
  }
    public function render()
    {
      $this->TableList=MasCenters::get();
        return view('livewire.masr.masr-center-select',$this->TableList);
    }
}
