<?php

namespace App\Http\Livewire\Admin;

use App\Models\Customers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminPage extends Component
{

  protected function FalseAll(){
      $this->emitTo('admin.manage-roles','show',False);
      $this->emitTo('admin.inp-user','show',False);
      $this->emitTo('admin.inp-company','show',False);
      $this->emitTo('admin.rep-company','show',False);
      $this->emitTo('admin.rep-users','show',False);
      $this->emitTo('admin.rep-old-roles','show',false);
      $this->emitTo('admin.rep-roles','show',false);
  }
  public function InpUser(){
    $this->FalseAll();
    $this->emitTo('admin.inp-user','show',True);
  }
  public function InpCompany(){
    $this->FalseAll();
    $this->emitTo('admin.inp-company','show',True);
  }
  public function RepCompany(){
    $this->FalseAll();
    $this->emitTo('admin.rep-company','show',True);
  }
    public function RepUsers(){
        $this->FalseAll();
        $this->emitTo('admin.rep-users','show',True);
    }
    public function InpRole(){
        $this->FalseAll();
        $this->emitTo('admin.manage-roles','show',True);
        $this->emitTo('admin.rep-old-roles','show',True);
    }
    public function RepRole(){
        $this->FalseAll();

        $this->emitTo('admin.rep-roles','show',True);
    }




    public function render()
    {
        return view('livewire.admin.admin-page');
    }
}
