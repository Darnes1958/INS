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

    protected $listeners = ['show','refreshComponent' => '$refresh'];

    public function show($show){

        $this->Show=$show;
    }
    public function selectItem($name){
        info('here');
      $this->emitTo('admin.manage-roles','TakeOldRole',$name);
    }
    public function render()
    {

        return view('livewire.admin.rep-old-roles',[
        'RootTable'=>DB::connection('Daibany')->table('sys_roots')->paginate(10),
        'OldRoleTable'=>DB::connection('Daibany')->table('sys_roles')
            ->orderBy('role_root','asc')->paginate(10),
        'RolesTable'=>Role::paginate(10),
        'PermissionTable'=>Permission::paginate(10),
        ]);

    }
}
