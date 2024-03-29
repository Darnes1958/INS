<?php

namespace App\Http\Livewire\Admin;

use App\Imports\KaemaModelImport;
use App\Models\excel\KaemaModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class Kaema extends Component
{
  use WithFileUploads;
  public $file;
  public $filename;
  public $Show=false;
  public $ShowDo=false;
  public $TajNo=0;
  public $BankRadio='wahda';
  public $WithDel=true;


  protected $listeners = ['show'];

  public function show($show){

    $this->Show=$show;
  }
  public function Take(){
    if ($this->WithDel)
      KaemaModel::on(Auth()->user()->company)->where('Taj',$this->TajNo)->delete();
    $this->filename='c:\Excel\Kaema\\'.Auth()->user()->company.'.xlsx';

    $this->ShowDo=true;

  }
    public function render()
    {
        return view('livewire.admin.kaema');
    }
}
