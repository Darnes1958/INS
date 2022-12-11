<?php

namespace App\Http\Livewire\Amma;

use Livewire\Component;

class DailyRep extends Component
{
    public $RepRadio='buys_view';
    public $RepDate='order_date_input';
    public $RepSearch1='jeha_name';

    public $DateVal;

    public function ChkDateAndGo(){
      $this->emitTo('amma.daily-rep-table','TakeDate',$this->DateVal);

    }
  public function updatedDateVal(){
    $this->emitTo('amma.daily-rep-table','TakeDate',$this->DateVal);
  }



    public function render()
    {
        return view('livewire.amma.daily-rep');
    }
}
