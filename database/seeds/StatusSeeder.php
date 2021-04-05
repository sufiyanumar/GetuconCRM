<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = Status::get();
        if ($status->count()) {
            foreach ($status as $status) {
                $status->delete();
            }
        }

        DB::table('statuses')->insert([
            'name' => 'Opened',
        ]);
        DB::table('statuses')->insert([
            'name' => 'Transferred',
        ]);
        DB::table('statuses')->insert([
            'name' => 'In Progress',
        ]);
        DB::table('statuses')->insert([
            'name' => 'Answered',
        ]);
        DB::table('statuses')->insert([
            'name' => 'Query',
        ]);
        DB::table('statuses')->insert([
            'name' => 'Done',
        ]);
        DB::table('statuses')->insert([
            'name' => 'Invoiced',
        ]);
        DB::table('statuses')->insert([
            'name' => 'On Hold',
        ]);
        DB::table('statuses')->insert([
            'name' => 'Closed',
        ]);
    }
}
