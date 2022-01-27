<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the default categories
        \DB::table('categories')->insert([
            'name' => 'All',
            'value' => 'all',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
            
        \DB::table('categories')->insert([
            'name' => 'Crops',
            'value' => 'categ-1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('categories')->insert([
            'name' => 'Livestocks',
            'value' => 'categ-2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('categories')->insert([
            'name' => 'Dairy',
            'value' => 'categ-3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('categories')->insert([
            'name' => 'Fish-Farming',
            'value' => 'categ-4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('categories')->insert([
            'name' => 'Machineries',
            'value' => 'categ-5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \DB::table('categories')->insert([
            'name' => 'Others',
            'value' => 'categ-6',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
