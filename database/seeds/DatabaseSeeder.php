<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(StatusSeeder::class);
        // $this->call(CategorySeeder::class);
        // $this->call(GoodWillSeeder::class);
        // $this->call(RoleSeeder::class);
        // $this->call(PermissionSeeder::class);
        // $this->call(RolePermissionSeeder::class);
        $this->call(UserSeeder::class);
        // $this->call(OrganizationSeeder::class);
        // $this->call(TicketSeeder::class);
    }
}
