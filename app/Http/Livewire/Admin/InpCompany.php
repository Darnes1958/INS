<?php

namespace App\Http\Livewire\Admin;

use App\Models\Customers;
use Livewire\Component;

class InpCompany extends Component
{
  public $database;
  public $CompanyName;
  public $CompanyNameSuffix;

  public $Show=false;

  protected $listeners = ['show'];

  public function show($show){

    $this->Show=$show;
  }


  public function SaveCompany(){
    Customers::insert([
      'CompanyName' => $this->CompanyName,
      'CompanyNameSuffix' => $this->CompanyNameSuffix,
      'Company' => $this->database,
    ]);
    $this->CompanyName='';
    $this->CompanyNameSuffix='';
  }

    public function render()
    {
        return view('livewire.admin.inp-company');
    }
}
