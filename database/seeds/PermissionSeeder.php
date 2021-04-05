<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::get();
        if ($permissions->count()) {
            foreach ($permissions as $permission) {
                $permission->delete();
            }
        }
        //Users Permission
        DB::table('permissions')->insert([
            'name' => 'VIEW_USERS',
            'slug' => 'View Users',
        ]);
        DB::table('permissions')->insert([
            'name' => 'CREATE_USER',
            'slug' => 'Create User',
        ]);
        DB::table('permissions')->insert([
            'name' => 'UPDATE_USER',
            'slug' => 'Update User',
        ]);
        DB::table('permissions')->insert([
            'name' => 'DELETE_USER',
            'slug' => 'Delete User',
        ]);
        //Roles Permission
        DB::table('permissions')->insert([
            'name' => 'VIEW_ROLES',
            'slug' => 'View Roles',
        ]);
        DB::table('permissions')->insert([
            'name' => 'CREATE_ROLE',
            'slug' => 'Create Role',
        ]);
        DB::table('permissions')->insert([
            'name' => 'UPDATE_ROLE',
            'slug' => 'Update Role',
        ]);
        DB::table('permissions')->insert([
            'name' => 'DELETE_ROLE',
            'slug' => 'Delete Role',
        ]);
        //Organization Permissions
        DB::table('permissions')->insert([
            'name' => 'VIEW_ORGANIZATIONS',
            'slug' => 'View Organizations',
        ]);
        DB::table('permissions')->insert([
            'name' => 'CREATE_ORGANIZATION',
            'slug' => 'Create Organization',
        ]);
        DB::table('permissions')->insert([
            'name' => 'UPDATE_ORGANIZATION',
            'slug' => 'Update Organization',
        ]);
        DB::table('permissions')->insert([
            'name' => 'DELETE_ORGANIZATION',
            'slug' => 'Delete Organization',
        ]);
        //Tickets Permissions
        DB::table('permissions')->insert([
            'name' => 'VIEW_TICKETS',
            'slug' => 'View Tickets',
        ]);
        DB::table('permissions')->insert([
            'name' => 'CREATE_TICKET',
            'slug' => 'Create Ticket',
        ]);
        DB::table('permissions')->insert([
            'name' => 'UPDATE_TICKET',
            'slug' => 'Update Ticket',
        ]);
        DB::table('permissions')->insert([
            'name' => 'DELETE_TICKET',
            'slug' => 'Delete Ticket',
        ]);
        DB::table('permissions')->insert([
            'name' => 'SEND_UPDATE_TICKET',
            'slug' => 'Send Ticket Update',
        ]);
        //Ticket Attachment Permissions
        DB::table('permissions')->insert([
            'name' => 'VIEW_TICKET_ATTACHMENTS',
            'slug' => 'Create Ticket Attachments',
        ]);
        DB::table('permissions')->insert([
            'name' => 'CREATE_TICKET_ATTACHMENT',
            'slug' => 'Create Ticket Attachment',
        ]);
        DB::table('permissions')->insert([
            'name' => 'DELETE_TICKET_ATTACHMENT',
            'slug' => 'Delete Ticket Attachment',
        ]);
        //Reports Permission
        DB::table('permissions')->insert([
            'name' => 'VIEW_REPORTS',
            'slug' => 'Create Reports',
        ]);
    }
}
