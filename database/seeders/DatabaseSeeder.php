<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => '1@email.com',
            'password' => Hash::make('password'),
        ]);

        Event::factory(10)->create();
    }
}
