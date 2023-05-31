<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        \App\Models\User::factory(30)->create();
        \App\Models\Reseller::factory(10)->create();
        \App\Models\Customer::factory(10)->create();
        \App\Models\Computer::factory(10)->create();

        $user1 = \App\Models\User::factory()->create([
             'name' => 'Administrator',
             'email' => 'admin@tksbr.com',
             'password' => bcrypt('password'),
             'type' => 'admin',
             'status' => true
        ]);

        $user2 = \App\Models\User::factory()->create([
            'name' => 'Reseller',
            'email' => 'reseller@tksbr.com',
            'password' => bcrypt('password'),
            'type' => 'reseller',
            'status' => true
        ]);
    }
}
