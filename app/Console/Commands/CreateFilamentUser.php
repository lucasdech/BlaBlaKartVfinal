<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateFilamentUser extends Command
{
    protected $signature = 'make:filament-user';

    protected $description = 'Create a user that can access the Filament admin panel';

    public function handle()
    {
        $firstname = $this->ask('First Name');
        $lastname = $this->ask('Last Name');
        $email = $this->ask('Email Address');
        $password = $this->secret('Password');

        $user = User::create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);

        $this->info("Filament user created successfully.");
        $this->info("Email: {$email}");
        $this->info("Password: ********");
    }
}