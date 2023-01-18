<?php

namespace App\Http\Livewire\Manager;

use App\Models\User;
use FontLib\Table\Table;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class InpRolem extends Component
{
  use WithPagination;
  protected $paginationTheme = 'bootstrap';
  public $TheUserListIsSelectd;
  public $UserNo;
  public $name;
  public $Show=false;

  protected $listeners = ['show'];
  public function show($show){
    $this->Show=$show;
  }

  public function updatedTheUserListIsSelectd(){
    $this->TheUserListIsSelectd=0;
    $this->name=User::find($this->UserNo)->name;
    $this->emit('TakeUserNo',$this->UserNo);

  }
  public function selectPushRole($id){
    $user=User::where('id',$this->UserNo)->first();
    $role=Role::findById($id)->name;
    $user->assignRole($role);
  }
  public function selectPushPer($id){
    $user=User::where('id',$this->UserNo)->first();
    $per=Permission::findById($id)->name;
    $user->givePermissionTo($per);

  }

  public function selectPullRole($id){
    $user=User::where('id',$this->UserNo)->first();
    $role=Role::findById($id)->name;
    $user->removeRole($role);

  }
  public function selectPullPer($id){
    $user=User::where('id',$this->UserNo)->first();
    $per=Permission::findById($id)->name;
    $user->revokePermissionTo($per);

  }

    public function render()
    {
        $activeRoles = DB::table('model_has_roles')->select('role_id')->where('model_id', $this->UserNo);
        $activePer   = DB::table('model_has_permissions')->select('role_id')->where('model_id', $this->UserNo);
        return view('livewire.manager.inp-rolem',[
          'HasRole'=>DB::table('model_has_roles')->where('model_id',$this->UserNo)
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->whereNotIn('roles.name', [ 'manager', 'admin','SupperUser'])
          ->select('roles.id','roles.name')
          ->paginate(15),
          'NotHasRole'=>DB::table('roles')
            ->whereNotIn('id', $activeRoles)
            ->whereNotIn('roles.name', [ 'manager', 'admin','SupperUser'])
            ->paginate(15),
          'HasPer'=>DB::table('model_has_permissions')->where('model_id',$this->UserNo)
            ->join('permissions','model_has_permissions.permission_id','=','permissions.id')

            ->select('permissions.id','permissions.name')
            ->paginate(15),
          'NotHasPer'=>DB::table('permissions')
            ->whereNotIn('id', $activeRoles)

            ->paginate(15),

        ]);
    }
}
