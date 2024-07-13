<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MyRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oldper=DB::connection('Other')->table('sys_roles')->get();
        foreach ($oldper as $item) {
            if ( ! Permission::where('name',$item->role)->first())
                Permission::create(['name' => $item->role]);
        }

        if (  Role::where('name','admin')->doesntExist()) Role::create(['name' => 'admin']);
        if (  Role::where('name','manager')->doesntExist()) Role::create(['name' => 'manager']);
        if (  Role::where('name','SupperUser')->doesntExist()) Role::create(['name' => 'SupperUser']);
        if (  Role::where('name','info')->doesntExist()) Role::create(['name' => 'info']);

        $oldrole=DB::connection('Other')->table('sys_roots')->get();
        foreach ($oldrole as $item) {
            if ( Role::where('name',$item->role_root_name)->doesntExist())
                 Role::create(['name'=>$item->role_root_name]);
            $role=Role::where('name',$item->role_root_name)->first();
            $oldId=$item->role_root_no;
            $oldper=DB::connection('Other')->table('sys_roles')
                ->where('role_root',$oldId)
                ->orderBy('role_ser')
                ->get();
            foreach ($oldper as $oldone) {
               if ( ! $role->hasPermissionTo($oldone->role))
                   $role->givePermissionTo($oldone->role);
            }

            $role = Role::findByName('info');
            if ( ! $role->hasPermissionTo('عقود'))
             $role->givePermissionTo('عقود');

        }





    }
}
