<?php

namespace App\Http\Livewire\Admin;

use App\Models\Customers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminPage extends Component
{

  public function InpUser(){
    $this->emitTo('admin.inp-user','show',True);
    $this->emitTo('admin.inp-company','show',False);
    $this->emitTo('admin.rep-company','show',False);
  }
  public function InpCompany(){
    $this->emitTo('admin.inp-user','show',False);
    $this->emitTo('admin.inp-company','show',True);
    $this->emitTo('admin.rep-company','show',False);
  }
  public function RepCompany(){
    $this->emitTo('admin.inp-user','show',False);
    $this->emitTo('admin.inp-company','show',False);
    $this->emitTo('admin.rep-company','show',True);
  }




    public function render()
    {
        return view('livewire.admin.admin-page');
    }
}
