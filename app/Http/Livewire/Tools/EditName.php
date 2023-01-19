<?php

namespace App\Http\Livewire\Tools;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditName extends Component
{
  public $TheName;
  public $TheKey;
  public $Sender;
  public $TableName;
  public $KeyField;
  public $NameField;
  public $EditNameOpen=false;

  public $listeners=['TakeSenderInfo'];



  public function TakeSenderInfo($thename,$thekey,$tablename,$keyfield,$namefield){

    $this->TheName=$thename;
    $this->TheKey=$thekey;

    $this->TableName=$tablename;
    $this->KeyField=$keyfield;
    $this->NameField=$namefield;
    $this->EditNameOpen=True;
    $this->dispatchBrowserEvent('OpenEditNameModal');
  }

  public function CloseEditName(){
    $this->EditNameOpen=False;
    $this->dispatchBrowserEvent('CloseEditNameModal');

  }
  public function SaveName(){

   DB::connection(Auth()->user()->company)->table($this->TableName)
     ->where($this->KeyField,$this->TheKey)
     ->update([$this->NameField=>$this->TheName]);
    $this->CloseEditName();
  }

    public function render()
    {
        return view('livewire.tools.edit-name');
    }
}
