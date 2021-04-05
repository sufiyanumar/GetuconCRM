<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
        if ($role) {
            $role->delete();
        }
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Super Admin',
            'role_desc' => 'This is system default role for super admin',
            'system' => 1,
            'add_by' => 1,
            'add_ip' => '127.0.0.0',
            'update_by' => 1,
            'update_ip' => '127.0.0.0',
        ]);
        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'Admin',
            'role_desc' => 'This is system default role for admin',
            'system' => 1,
            'add_by' => 1,
            'add_ip' => '127.0.0.0',
            'update_by' => 1,
            'update_ip' => '127.0.0.0',
        ]);
        DB::table('roles')->insert([
            'id' => 3,
            'name' => 'Personnel Admin',
            'role_desc' => 'This is system default role for Personnel Admin',
            'system' => 1,
            'add_by' => 1,
            'add_ip' => '127.0.0.0',
            'update_by' => 1,
            'update_ip' => '127.0.0.0',
        ]);
        DB::table('roles')->insert([
            'id' => 4,
            'name' => 'Personnel',
            'role_desc' => 'This is system default role for Personnel',
            'system' => 1,
            'add_by' => 1,
            'add_ip' => '127.0.0.0',
            'update_by' => 1,
            'update_ip' => '127.0.0.0',
        ]);
        DB::table('roles')->insert([
            'id' => 5,
            'name' => 'Firma Admin',
            'role_desc' => 'This is system default role for Firma Admin',
            'system' => 1,
            'add_by' => 1,
            'add_ip' => '127.0.0.0',
            'update_by' => 1,
            'update_ip' => '127.0.0.0',
        ]);
        DB::table('roles')->insert([
            'id' => 6,
            'name' => 'Firma User',
            'role_desc' => 'This is system default role for Firma User',
            'system' => 1,
            'add_by' => 1,
            'add_ip' => '127.0.0.0',
            'update_by' => 1,
            'update_ip' => '127.0.0.0',
        ]);
    }
}
