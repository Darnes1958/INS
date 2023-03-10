<?php

namespace App\Http\Livewire\Admin;

use App\Models\aksat\kst_trans;
use App\Models\aksat\main;
use App\Models\buy\buy_tran;
use App\Models\buy\buys;
use App\Models\Customers;
use App\Models\stores\items;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    $this->redirect('/home');
  }
  public function BuyPrice(){
      $res=main::all();
      foreach ($res as $item){
          $trans=kst_trans::where('no',$item->no)->orderby('wrec_no')->get();
          $i=0;
          foreach ($trans as $ser) {$i+=1;kst_trans::where('wrec_no',$ser->wrec_no)->update(['ser'=>$i]);}
      }


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
      $this->emitTo('admin.from-excel2','show',false);
      $this->emitTo('admin.rep-log-user','show',False);
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
  public function FromExcel2(){
    $this->FalseAll();

    $this->emitTo('admin.from-excel2','show',True);
  }
    public function LogUser(){
        $this->FalseAll();

        $this->emitTo('admin.rep-log-user','show',True);
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
