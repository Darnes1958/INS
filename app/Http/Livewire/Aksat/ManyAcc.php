<?php

namespace App\Http\Livewire\Aksat;

use Livewire\Component;

class ManyAcc extends Component
{
    protected $listeners = [
        'GotoManyAcc',
    ];


  public function GotoManyAcc($bank,$acc){

    $this->emit('GetMany_Bank_Acc',$bank,$acc);
  }
    public function render()
    {
        return view('livewire.aksat.many-acc');
    }
}
