<?php

namespace Database\Seeders;

use App\Models\Trip;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        User::factory()->create([
            'firstname' => 'Hamza',
            'lastname' => 'Karfa',
            'email' => 'hamza@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            'avatar' => 'https://www.gravatar.com/avatar/HK',
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);
        Trip::factory(100)->create();

    }
}
