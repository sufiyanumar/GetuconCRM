<?php

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::where('id', 1)->first();
        if ($user) {
            $user->delete();
        }
        DB::table('users')->insert([
            'id' => 1,
            'username' => 'Super Admin',
            'password' => Hash::make('superadmin@123'),
            'role_id' => 1,
            'org_id' => 1,
            'first_name' => 'Super Admin',
            'surname' => 'CRM',
            'email' => 'superadmin@crm.com',
            'gsm' => 'NULL',
            'phone_no' => 'NULL',
            'get_email' => 0,
            'in_use' => 0,
            'ip' => '127.0.0.0',
            'last_login' => Carbon::now(),
            'add_by' => 1,
            'add_ip' => '127.0.0.0',
            'update_by' => 1,
            'update_ip' => '127.0.0.0',
            'remember_token' => 'NULL',
        ]);
    }
}
