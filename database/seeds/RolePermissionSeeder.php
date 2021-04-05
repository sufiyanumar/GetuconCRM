<?php

use App\Permission;
use App\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role = Role::where('name', 'Super Admin')->first();
        $permissions = Permission::get();
        if ($permissions->count() && $role) {
            foreach ($permissions as $permission) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $role->id,
                    'permission_id' => $permission->id,
                    'add_by' => 1,
                ]);
            }
        }
        $admin = Role::where('name', 'Admin')->first();
        $permissions = Permission::where('name', 'like', '%TICKET%')->get();
        if ($permissions->count() && $admin) {
            foreach ($permissions as $permission) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $admin->id,
                    'permission_id' => $permission->id,
                    'add_by' => 1,
                ]);
            }
        }
        $admin = Role::where('name', 'Personnel Admin')->first();
        $permissions = Permission::where('name', 'like', '%TICKET%')->orWhere('name', 'like', '%USER%')->get();
        if ($permissions->count() && $admin) {
            foreach ($permissions as $permission) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $admin->id,
                    'permission_id' => $permission->id,
                    'add_by' => 1,
                ]);
            }
        }
        $admin = Role::where('name', 'Personnel')->first();
        $permissions = Permission::where('name', 'like', '%TICKET%')->get();
        if ($permissions->count() && $admin) {
            foreach ($permissions as $permission) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $admin->id,
                    'permission_id' => $permission->id,
                    'add_by' => 1,
                ]);
            }
        }
        $admin = Role::where('name', 'Firma Admin')->first();
        $permissions = Permission::where('name', 'like', '%TICKET%')->orWhere('name', 'like', '%USER%')->get();
        if ($permissions->count() && $admin) {
            foreach ($permissions as $permission) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $admin->id,
                    'permission_id' => $permission->id,
                    'add_by' => 1,
                ]);
            }
        }
        $admin = Role::where('name', 'Firma User')->first();
        $permissions = Permission::where('name', 'like', '%TICKET%')->get();
        if ($permissions->count() && $admin) {
            foreach ($permissions as $permission) {
                DB::table('role_has_permissions')->insert([
                    'role_id' => $admin->id,
                    'permission_id' => $permission->id,
                    'add_by' => 1,
                ]);
            }
        }
    }
}
