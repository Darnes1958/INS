<?php

namespace App\Http\Livewire\Admin;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RepOldRoles extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $Show=false;
    public $Role_Id=4;

    protected $listeners = ['show','refreshComponent' => '$refresh','TakeRoleId'];

    public function TakeRoleId($id){
        $this->Role_Id=$id;
    }
    public function show($show){

        $this->Show=$show;
    }
    public function selectItem($name){

      $this->emitTo('admin.manage-roles','TakeOldRole',$name);
    }
    public function selectRole($id){
     $this->Role_Id=$id;

    }
    public function render()
    {
        $role=Role::where('id',$this->Role_Id)->first();
        $permission=$role->permissions;

        return view('livewire.admin.rep-old-roles',[
        'RootTable'=>DB::connection('Daibany')->table('sys_roots')->paginate(10),
        'OldRoleTable'=>DB::connection('Daibany')->table('sys_roles')
            ->orderBy('role_root','asc')->paginate(10),
        'RolesTable'=>Role::paginate(10),
        'PermissionTable'=>Permission::paginate(10),
        'permission'=>$permission,
        ]);

    }
}
