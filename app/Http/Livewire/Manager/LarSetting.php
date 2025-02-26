<?php

namespace App\Http\Livewire\Manager;

use Livewire\Component;


class LarSetting extends Component
{
    public $NakInc;
    public $TakInc;
    public $ArcBtn;
    public $SellSalOrMak;
    public $ToSal;
    public $canChangePrice;
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
      if ($res->ToSal=='yes') $this->ToSal=true; else $this->ToSal=false;
      $this->canChangePrice=$res->canChangePrice==1;
      info($this->canChangePrice);
      $this->SellSalOrMak=$res->SellSalOrMak;
    }
    public function SaveSetting(){
      if ($this->NakInc) $nak='inc'; else $nak='notinc';
      if ($this->TakInc) $tak='inc'; else $tak='notinc';
      if ($this->ArcBtn) $arc='rep'; else $arc='menue';
      if ($this->ToSal) $tosal='yes'; else $tosal='no';
      \App\Models\LarSetting::first()->update([
        'SellNakInc'=>$nak,
        'SellTakInc'=>$tak,
        'ArcBtn'=>$arc,
        'SellSalOrMak'=>$this->SellSalOrMak,
        'ToSal'=>$tosal,
        'canChangePrice'=>$this->canChangePrice,
      ]);
    }
    public function render()
    {
        return view('livewire.manager.lar-setting');
    }
}
