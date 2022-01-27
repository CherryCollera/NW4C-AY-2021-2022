<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QtyQtypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Create the default categories
         \DB::table('qty_type')->insert([
            'name' => 'Kilogram',
            'value' => 'categ-1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
         \DB::table('qty_type')->insert([
            'name' => 'Liter',
            'value' => 'categ-2',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

         \DB::table('qty_type')->insert([
            'name' => 'Box',
            'value' => 'categ-3',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

         \DB::table('qty_type')->insert([
            'name' => 'Sack',
            'value' => 'categ-4',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

         \DB::table('qty_type')->insert([
            'name' => 'Truck',
            'value' => 'categ-5',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

         \DB::table('qty_type')->insert([
            'name' => 'Piece',
            'value' => 'categ-6',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

         \DB::table('qty_type')->insert([
            'name' => 'Tray',
            'value' => 'categ-7',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
