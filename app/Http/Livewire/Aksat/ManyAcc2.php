<?php

namespace App\Http\Livewire\Aksat;

use Livewire\Component;

class ManyAcc2 extends Component
{
    protected $listeners = [
        'GotoManyAcc',
    ];


  public function GotoManyAcc($acc){

    $this->emit('GetMany_Acc',$acc);
  }
    public function render()
    {
        return view('livewire.aksat.many-acc2');
    }
}
