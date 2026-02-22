<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@rentapp.pl'],
            [
                'name' => 'Administrator',
                'email' => 'admin@rentapp.pl',
                'password' => Hash::make('admin1234'),
                'email_verified_at' => now(),
            ]
        );
    }
}
