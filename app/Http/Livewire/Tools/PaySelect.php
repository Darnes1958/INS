<?php

namespace App\Http\Livewire\Tools;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PaySelect extends Component
{
  public $TypeNo;
  public $TypeName;
  public $PayList;


  protected $listeners = [
    'TakePayNo',
  ];

  public function TakePayNo($wj,$wn){

    if(!is_null($wj)) {
      $this->TypeNo = $wj;
      $this->TypeName = $wn;

    }
  }

  public function hydrate()
  {
    $this->emit('pay-change-event');
  }
  public function render()
    {

      $this->PayList=DB::connection(Auth()->user()->company)->table('price_type')->get();
        return view('livewire.tools.pay-select',$this->PayList);
    }
}
