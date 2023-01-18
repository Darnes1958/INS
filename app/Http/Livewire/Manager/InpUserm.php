<?php

namespace App\Http\Livewire\Manager;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class InpUserm extends Component
{
  public $name;
  public $password;

  public $Show=false;

  protected $listeners = ['show'];
  public function show($show){
    $this->Show=$show;
  }

  public function SaveUser(){
    $empno=DB::connection(Auth()->user()->company)->table('pass')->max('EMP_NO')+1;
    DB::connection(Auth()->user()->company)->table('pass')->insert([
      'EMP_NO'=>$empno,
      'EMP_NAME'=>$this->name,
      'pass_no'=>$this->password,
      'pass_type'=>3,
      'place'=>0,
    ]);

    User::create([
      'name' => $this->name,
      'email' => 'Nuri@Gmail.com',
      'password' => Hash::make($this->password),
      'username' => $this->name,
      'company' =>Auth()->user()->company,
      'empno' => $empno,
      'IsAdmin' => 0,
    ]);
    $this->name='';

    $this->password='';
    $this->emit('gotonext','name');

  }
  public function render()
    {
        return view('livewire.manager.inp-userm');
    }
}
