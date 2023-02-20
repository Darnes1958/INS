<?php

namespace App\Http\Livewire\Manager;

use Livewire\Component;


class LarSetting extends Component
{
    public $NakInc;
    public $TakInc;
    public $ArcBtn;

  public $Show=false;

  protected $listeners = ['show'];
  public function show($show){
    $this->Show=$show;
  }

    public function mount(){

      $res=\App\Models\LarSetting::first();
      if ($res->ArcBtn=='rep') $this->ArcBtn=true; else $this->ArcBtn=false;
      if ($res->SellTakInc=='inc') $this->TakInc=true; else $this->TakInc=false;
      if ($res->SellNakInc=='inc') $this->NakInc=true; else $this->NakInc=false;
    }
    public function SaveSetting(){
      if ($this->NakInc) $nak='inc'; else $nak='notinc';
      if ($this->TakInc) $tak='inc'; else $tak='notinc';
      if ($this->ArcBtn) $arc='rep'; else $arc='menue';
      \App\Models\LarSetting::first()->update([
        'SellNakInc'=>$nak,
        'SellTakInc'=>$tak,
        'ArcBtn'=>$arc,
      ]);
    }
    public function render()
    {
        return view('livewire.manager.lar-setting');
    }
}
