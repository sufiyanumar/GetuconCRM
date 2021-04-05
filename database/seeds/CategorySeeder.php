<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = Category::get();
        if ($category->count()) {
            foreach ($category as $category) {
                $category->delete();
            }
        }

        DB::table('categories')->insert([
            'name' => 'Network',
        ]);
        DB::table('categories')->insert([
            'name' => 'Hardware',
        ]);
        DB::table('categories')->insert([
            'name' => 'Software',
        ]);
        DB::table('categories')->insert([
            'name' => 'Other',
        ]);
        DB::table('categories')->insert([
            'name' => 'CRM Gulcons',
        ]);
        DB::table('categories')->insert([
            'name' => 'Project',
        ]);
        DB::table('categories')->insert([
            'name' => 'CRM',
        ]);
    }
}
