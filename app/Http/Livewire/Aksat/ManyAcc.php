<?php

namespace App\Http\Livewire\Aksat;

use Livewire\Component;

class ManyAcc extends Component
{
  public $post3='main';
  public function GotoManyAcc($bank,$acc){
    $this->emit('GetWhereEquelValue3',$bank,$acc);
  }
    public function render()
    {
        return view('livewire.aksat.many-acc');
    }
}
