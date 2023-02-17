<?php

namespace App\Http\Livewire\Masr;

use App\Models\masr\MasTypeDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MasrDetailSelect extends Component
{
  public $DetailNo;

  public $TableList;
  public $MasType=0;



  protected $listeners = [
    'TakeDetailNo','TakeMasType','refreshComponent' => '$refresh'
  ];
  public function TakeMasType($MasType){
      $this->MasType=$MasType;
  }
  public function TakeDetailNo($wo){


      $this->DetailNo = $wo;

  }
  function mount(){

  }
  public function hydrate(){
    $this->emit('detail-change-event');
  }
    public function render()
    {
      $this->TableList=MasTypeDetails::where('MasType',$this->MasType)->get();
        return view('livewire.masr.masr-detail-select',$this->TableList);
    }
}
