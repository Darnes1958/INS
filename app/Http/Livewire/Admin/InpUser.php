<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class InpUser extends Component
{
  public $name;
  public $username;
  public $database;
  public $password;
  public $email;
  public $IsAdmin=0;
  public $empno;

  public $Show=false;

  protected $listeners = ['show'];

  public function show($show){

    $this->Show=$show;
  }

  public function SaveUser(){
    User::create([
      'name' => $this->name,
      'email' => $this->email,
      'password' => Hash::make($this->password),
      'username' => $this->username,
      'company' => $this->database,
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
