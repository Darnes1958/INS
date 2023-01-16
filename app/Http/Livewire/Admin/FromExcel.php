<?php

namespace App\Http\Livewire\Admin;

use App\Http\Controllers\ExcelController;
use App\Models\excel\FromExcelModel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;




class FromExcel extends Component
{
  use WithFileUploads;
  public $file;
  public $filename;
  public $Show=false;
  public $ShowDo=false;


  protected $listeners = ['show'];



  public function show($show){

    $this->Show=$show;
  }
  public function Take(){
      FromExcelModel::on(Auth()->user()->company)->truncate();
      $this->filename='c:\Excel\\'.Auth()->user()->company.'.xlsx';

      $this->ShowDo=true;

  }

    public function render()
    {
        return view('livewire.admin.from-excel');
    }
}
