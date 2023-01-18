<?php

namespace App\Http\Livewire\Manager;

use App\Models\User;
use Livewire\Component;

class UserSelect extends Component
{
  public $UserNo;

  public $UserList;


  protected $listeners = [
    'TakeUserNo','RefreshMe'=>'$refresh',
  ];

  public function TakeUserNo($userno){

    $this->UserNo = $userno;

  }

  public function hydrate(){
    $this->emit('user-change-event');
  }
    public function render()
    {

        $this->UserList=User::where('company',auth()->user()->company)->where('id','!=',1)->get();
        return view('livewire.manager.user-select',$this->UserList);
    }
}
