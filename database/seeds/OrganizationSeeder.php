<?php

use App\Organization;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organization = Organization::where('id', 1)->first();
        if ($organization) {
            $organization->delete();
        }
        DB::table('organizations')->insert([
            'id' => 1,
            'org_name' => 'CRM Company',
            'address' => 'CRM Company Address',
            'rating' => 0,
            'contract' => 'None',
            'contract_frequency' => 0,
            'contract_start_date' => Carbon::now(),
            'contract_end_date' => Carbon::now(),
            'price' => 0,
            'transport_price' => 0,
            'add_by' => 1,
            'add_ip' => '127.0.0.0',
            'update_by' => 1,
            'update_ip' => '127.0.0.0',
        ]);
    }
}
