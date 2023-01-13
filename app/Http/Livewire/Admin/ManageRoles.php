<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ManageRoles extends Component
{
    public $newRole;
    public $newPermission;

    public $ThePermission;
    public $TheRole;
    public $TheUser;

    public $Show=false;

    protected $listeners = ['show','TakeOldRole'];

    public function TakeOldRole($name){

        $this->newRole=$name;
    }
    public function SaveRelation(){
        $role=Role::where('name',$this->TheRole)->first();
        $permession=Permission::where('name',$this->ThePermission)->first();
        $role->givePermissionTo($permession);
        $this->emitTo('admin.rep-old-roles','TakeRoleId',$role->id);
        $this->emitTo('admin.rep-old-roles','refreshComponent');
        $this->ThePermission='';
        $this->emit('gotonext','ThePermission');

    }
    public function RemoveRelation(){
        $role=Role::where('name',$this->TheRole)->first();
        $permession=Permission::where('name',$this->ThePermission)->first();
        $role->revokePermissionTo($this->ThePermission);
        $this->emitTo('admin.rep-old-roles','TakeRoleId',$role->id);
        $this->emitTo('admin.rep-old-roles','refreshComponent');


        $this->ThePermission='';
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
  public function RemoveUserPermission(){
    $user=User::where('name',$this->TheUser)->first();
    $user->revokePermissionTo($this->ThePermission);
    $this->emitTo('admin.rep-old-roles','refreshComponent');
    $this->ThePermission='';
  }

    public function SaveUserRole(){
        $user=User::where('name',$this->TheUser)->first();
        $user->assignRole($this->TheRole);
        $this->emitTo('admin.rep-old-roles','refreshComponent');
        $this->TheRole='';

    }
  public function RemoveUserRole(){
    $user=User::where('name',$this->TheUser)->first();
    $user->removeRole($this->TheRole);
    $this->emitTo('admin.rep-old-roles','refreshComponent');
    $this->TheRole='';

  }
  public function SaveUserPermission(){
    $user=User::where('name',$this->TheUser)->first();
    $user->givePermissionTo($this->ThePermission);


    $this->emitTo('admin.rep-old-roles','refreshComponent');
    $this->ThePermission='';

  }
    public function render()
    {

        $existrole = DB::table('useradmin.dbo.roles')->select('name');
        $existpermission = DB::table('useradmin.dbo.permissions')->select('name');
        return view('livewire.admin.manage-roles',
            ['roleTable' => DB::connection(Auth()->user()->company)->table('sys_roots')
                ->whereNotIn('role_root_name', $existrole)
                ->get(),
             'permissionTable' => DB::connection(Auth()->user()->company)->table('sys_roles')
                 ->whereNotIn('role', $existpermission)
                 ->orderBy('role_root')
                 ->orderBy('role_ser')

                 ->get(),
             'role2Table' =>Role::all(),

             'per2Table' =>Permission::orderby('id')->get() ,
              'users'=>User::all(),
                ]);
    }
}
