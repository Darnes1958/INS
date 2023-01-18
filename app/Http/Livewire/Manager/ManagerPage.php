<?php

namespace App\Http\Livewire\Manager;

use Livewire\Component;

class ManagerPage extends Component
{
  protected function FalseAll(){

    $this->emitTo('manager.inp-userm','show',False);
    $this->emitTo('manager.inp-rolem','show',False);
    $this->emitTo('admin.rep-old-roles','show',False);

  }
  public function InpUser(){
    $this->FalseAll();
    $this->emitTo('manager.inp-userm','show',True);

  }
  public function InpRole(){
    $this->FalseAll();

    $this->emitTo('manager.inp-rolem','show',True);
  }
    public function RepRole(){
        $this->FalseAll();

        $this->emitTo('admin.rep-old-roles','show',True);
    }

    public function render()
    {
        return view('livewire.manager.manager-page');
    }
}
