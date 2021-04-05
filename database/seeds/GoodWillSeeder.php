<?php

use App\GoodWill;
use Illuminate\Database\Seeder;

class GoodWillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $goodWill = GoodWill::get();
        if ($goodWill->count()) {
            foreach ($goodWill as $goodWill) {
                $goodWill->delete();
            }
        }
        DB::table('good_wills')->insert([
            'frequency' => '0',
        ]);
        DB::table('good_wills')->insert([
            'frequency' => '10',
        ]);
        DB::table('good_wills')->insert([
            'frequency' => '20',
        ]);
        DB::table('good_wills')->insert([
            'frequency' => '30',
        ]);
        DB::table('good_wills')->insert([
            'frequency' => '40',
        ]);
        DB::table('good_wills')->insert([
            'frequency' => '50',
        ]);
        DB::table('good_wills')->insert([
            'frequency' => '60',
        ]);
        DB::table('good_wills')->insert([
            'frequency' => '70',
        ]);
        DB::table('good_wills')->insert([
            'frequency' => '80',
        ]);
        DB::table('good_wills')->insert([
            'frequency' => '90',
        ]);
        DB::table('good_wills')->insert([
            'frequency' => '100',
        ]);
    }
}
