<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class InpUser extends Component
{
  public $name;
  public $username;

  public $password=12345678;
  public $email='Nuri@Gmail';
  public $IsAdmin=0;
  public $empno;

  public $Show=false;

  protected $listeners = ['show'];


    public $TheEmpListIsSelectd;

    public function updatedTheEmpListIsSelectd(){
     $this->TheEmpListIsSelectd=0;

        $res=DB::connection(Auth()->user()->company)->table('pass')->where('EMP_NO',$this->empno)->first();

        $this->name=$res->EMP_NAME;
        $this->username=$res->EMP_NAME;

    }

  public function show($show){

    $this->Show=$show;
  }

  public function SaveUser(){
    User::create([
      'name' => $this->name,
      'email' => $this->email,
      'password' => Hash::make($this->password),
      'username' => $this->username,
      'company' =>Auth()->user()->company,
      'empno' => $this->empno,
      'IsAdmin' => $this->IsAdmin,
    ]);
    $this->name='';
    $this->username='';
    $this->password='';
    $this->email='';
    $this->IsAdmin=0;
    $this->empno='';

  }
    public function render()
    {

        return view('livewire.admin.inp-user');
    }
}
