<?php

namespace App\Http\Livewire\Admin;

use App\Models\Customers;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RepCompany extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';

  public $Show=false;

  protected $listeners = ['show'];

  public function show($show){

    $this->Show=$show;
  }

    public function render()
    {
      $this->Tabledata=Customers::all();
        return view('livewire.admin.rep-company',[
          'Tabledata'=>Customers::all()
        ]);
    }
}
