<?php

namespace App\Http\Livewire\Buy;

use App\Models\jeha\jeha;
use Livewire\Component;

class Testselect extends Component
{
   public $jehal;
   public $jehanamel;
   public $supplist;

  protected $listeners = [
    'jehafound',
  ];

  public function jehafound($wj,$wn){

    if(!is_null($wj)) {
      $this->jehal = $wj;
      $this->jehanamel = $wn;


    }
  }

   public function hydrate(){

     $this->emit('data-change-event');
   }
   public function updatedJehal(){
     info($this->jehal);
}
    public function render()
    {
      $this->supplist=jeha::where('jeha_type',2)->where('available',1)->get();
        return view('livewire.buy.testselect',$this->supplist);
    }
}
