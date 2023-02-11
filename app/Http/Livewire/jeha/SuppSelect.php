<?php

namespace App\Http\Livewire\Jeha;

use App\Models\jeha\jeha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Livewire\Component;

class SuppSelect extends Component
{
  public $SuppNo;
  public $SuppName;
  public $SuppList;

  protected $listeners = [
    'jehafound',
  ];

  public function jehafound($wj,$wn){

    if(!is_null($wj)) {
      $this->SuppNo = $wj;
      $this->SuppName = $wn;


    }
  }


  public function hydrate(){

    $this->emit('data-change-event');
  }
    public function render()
    {


      $this->SuppList=jeha::on(Auth()->user()->company)
          ->where('jeha_type',2)
          ->where('available',1)
          ->when(!Auth::user()->can('عميل خاص'),function($q){
              $q->where('acc_no','!=',1);
          })->get();
      return view('livewire.jeha.supp-select',$this->SuppList);
    }
}
