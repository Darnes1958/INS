<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class RepRoles extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Show=false;
    public $User_Id=4;

    protected $listeners = ['show','refreshComponent' => '$refresh'];


    public function show($show){

        $this->Show=$show;
    }
    public function selectUser($id){

        $this->User_Id=$id;
    }

    public function render()
    {

//'UserRole'=>User::where('id',$this->User_Id)->with('roles')->get(),
        return view('livewire.admin.rep-roles',[
            'UserRole'=>User::find($this->User_Id)->roles()->orderBy('name')->get(),

            'UserPer'=>User::find($this->User_Id)->permissions()->orderBy('name')->get(),
            'Users'=>User::paginate(10),

        ]);
    }
}
