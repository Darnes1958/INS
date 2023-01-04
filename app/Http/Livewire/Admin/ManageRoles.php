<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRoles extends Component
{
    public $newRole;
    public $newPermission;

    public $Show=false;

    protected $listeners = ['show','TakeOldRole'];

    public function TakeOldRole($name){
        info($name);
        $this->newRole=$name;
    }

    public function show($show){

        $this->Show=$show;
    }
    public function SaveRole(){

     if ($this->newRole) {Role::create(['name' => $this->newRole]);
         $this->newRole='';
         $this->emitTo('admin.rep-old-roles','refreshComponent');}
    }
    public function SavePermission(){
        if ($this->newPermission) {Permission::create(['name' => $this->newPermission]);
            $this->newPermission='';
            $this->emitTo('admin.rep-old-roles','refreshComponent');}
    }
    public function render()
    {
        return view('livewire.admin.manage-roles');
    }
}
