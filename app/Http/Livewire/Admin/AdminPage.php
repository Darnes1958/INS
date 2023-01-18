<?php

namespace App\Http\Livewire\Admin;

use App\Models\Customers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Jenssegers\Agent\Agent;

class AdminPage extends Component
{
public $text;

public $database='Daibany';
public $ThedatabaseListIsSelectd;

  public function updatedThedatabaseListIsSelectd(){
    $this->ThedatabaseListIsSelectd=0;
    User::find(auth()->user()->id)->update(['company'=>$this->database]);

    $this->emitTo('admin.empno-select','comp',$this->database);
  }
  protected function FalseAll(){
      $this->emitTo('admin.manage-roles','show',False);
      $this->emitTo('admin.inp-user','show',False);
      $this->emitTo('admin.inp-company','show',False);
      $this->emitTo('admin.rep-company','show',False);
      $this->emitTo('admin.rep-users','show',False);
      $this->emitTo('admin.rep-old-roles','show',false);
      $this->emitTo('admin.rep-roles','show',false);
      $this->emitTo('admin.from-excel','show',false);
      $this->emitTo('admin.to-hafitha','show',false);
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
  public function FromExcel(){
    $this->FalseAll();

    $this->emitTo('admin.from-excel','show',True);
  }
  public function ToHafitha(){
    $this->FalseAll();

    $this->emitTo('admin.to-hafitha','show',True);
  }



    public function Clickme(){
        $agent = new Agent();
        $this->text = $agent->platform();
    }




    public function render()
    {
        return view('livewire.admin.admin-page');
    }
}
