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
  public $stop='NoThing';

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
    if (! $this->UserNo) {$this->dispatchBrowserEvent('mmsg','يجب اختيار مستخدم'); return;};
    $user=User::where('id',$this->UserNo)->first();
    $role=Role::findById($id)->name;
    $user->assignRole($role);
  }
  public function selectPushPer($id){
    if (! $this->UserNo) {$this->dispatchBrowserEvent('mmsg','يجب اختيار مستخدم'); return;};
    $user=User::where('id',$this->UserNo)->first();
    $per=Permission::findById($id)->name;
    $user->givePermissionTo($per);

  }

  public function selectPullRole($id){
    if (! $this->UserNo) {$this->dispatchBrowserEvent('mmsg','يجب اختيار مستخدم'); return;};
    $user=User::where('id',$this->UserNo)->first();
    $role=Role::findById($id)->name;
    $user->removeRole($role);

  }
  public function selectPullPer($id){
    if (! $this->UserNo) {$this->dispatchBrowserEvent('mmsg','يجب اختيار مستخدم'); return;};
    $user=User::where('id',$this->UserNo)->first();
    $per=Permission::findById($id)->name;
    $user->revokePermissionTo($per);

  }
  public function StopUser(){
    if (! $this->UserNo) {$this->dispatchBrowserEvent('mmsg','يجب اختيار مستخدم'); return;};
    $user=User::where('id',$this->UserNo)->first();
    if ($user->isBanned()) $user->unban();
    else $user->ban([
      'comment' => 'موقوف من الإدارة',
    ]);

  }

    public function render()
    {
        $activeRoles = DB::table('model_has_roles')->select('role_id')->where('model_id', $this->UserNo);
        $activePer   = DB::table('model_has_permissions')->select('permission_id')->where('model_id', $this->UserNo);
        $perinrole=DB::table('role_has_permissions')->select('permission_id')->whereIn('role_id', $activeRoles);
        return view('livewire.manager.inp-rolem',[
          'HasRole'=>DB::table('model_has_roles')->where('model_id',$this->UserNo)
            ->join('roles','model_has_roles.role_id','=','roles.id')
            ->whereNotIn('roles.name', [ 'manager', 'admin','SupperUser'])
          ->select('roles.id','roles.name')
          ->paginate(12,  ['*'],'HasRolePage'),
          'NotHasRole'=>DB::table('roles')
            ->whereNotIn('id', $activeRoles)
            ->whereNotIn('roles.name', [ 'manager', 'admin','SupperUser'])
            ->paginate(12, ['*'], 'NotHasRolePage'),
          'HasPer'=>DB::table('model_has_permissions')->where('model_id',$this->UserNo)
            ->join('permissions','model_has_permissions.permission_id','=','permissions.id')
            ->whereNotIn('permissions.id',$perinrole)

            ->select('permissions.id','permissions.name')
            ->paginate(12, ['*'], 'HasPerPage'),
          'NotHasPer'=>DB::table('permissions')
            ->whereNotIn('id', $activePer)
            ->whereNotIn('id',$perinrole)
            ->paginate(12, ['*'], 'NotHasPerPage'),

        ]);
    }
}
