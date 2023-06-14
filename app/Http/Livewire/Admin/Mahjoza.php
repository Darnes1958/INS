<?php

namespace App\Http\Livewire\Admin;

use App\Imports\KaemaModelImport;
use App\Models\excel\KaemaModel;
use App\Models\excel\MahjozaModel;
use Livewire\Component;
use Livewire\WithFileUploads;

class Mahjoza extends Component
{
  use WithFileUploads;
  public $file;
  public $filename;
  public $Show=false;
  public $ShowDo=false;
  public $TajNo=0;
  public $BankRadio='wahda';
  public $DelRadio='WithDel';


  protected $listeners = ['show'];

  public function show($show){

    $this->Show=$show;
  }
  public function Take(){
    if ($this->DelRadio=='WithDel')
      MahjozaModel::on(Auth()->user()->company)->truncate();
    $this->filename='c:\Excel\Mahjoza\\'.Auth()->user()->company.'.xlsx';

    $this->ShowDo=true;

  }
    public function render()
    {
        return view('livewire.admin.mahjoza');
    }
}
