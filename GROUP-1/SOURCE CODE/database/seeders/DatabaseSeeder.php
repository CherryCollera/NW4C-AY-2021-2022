<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        // Create an account for me hehez
        \DB::table('users')->insert([
            'name' => 'John Michael Miguel',
            'email' => 'poodzia@gmail.com',
            'password' => Hash::make('password'),
            'birthdate' => '2000-06-05',
            'city' => 'balanga',
            'contact_number' => '09399537899',
            'bio' => 'Super Admin',
            'access_level' => 1,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Create the default categories
        $this->call([
            CategoriesSeeder::class,
            QtyQtypeSeeder::class,
        ]);
        
        // Only call seeder when on local env
        if (app()->environment('local')) {
            User::factory(100)
                ->hasPosts(36)
                ->create();
        }
    }
}
