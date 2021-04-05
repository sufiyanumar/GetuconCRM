<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = array(
            'IT',
            'Finance',
            'Audit',
            'Management',
        );
        $faker = Faker::create();
        for ($i = 1; $i <= 40; $i++) {
            DB::table('tickets')->insert([
                'name' =>  'Ticket for ' . $names[mt_rand(0, sizeof($names) - 1)],
                'description' =>  $faker->paragraph,
                'translate' => $faker->paragraph,
                'org_id' => 1,
                'user' => 1,
                'personnel' => 1,
                'status_id' => $faker->numberBetween(1, 9),
                'priority' => $faker->numberBetween(1, 5),
                'category' => $faker->numberBetween(1, 7),
                'good_will' => $faker->numberBetween(1, 80),
                'due_date' => Carbon::now()->subMonth($i),
                'coding' => '23:50',
                'consulting' => '23:50',
                'testing' => '23:50',
                'transport_price' => $faker->randomDigit,
                'add_by' => 1,
                'add_ip' => '127.0.0.0',
                'update_by' => 1,
                'update_ip' => '127.0.0.0',
                'created_at' => Carbon::now()->subMonth(rand(1, 12))
            ]);
        }
    }
}
