<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | DEFAULT DEVELOPER ADMIN
        |--------------------------------------------------------------------------
        |
        | This is the first/admin account created by the developer.
        | It does not require staff approval.
        |
        */

        User::updateOrCreate(
            [
                'email' => 'admin@restaurant.com',
            ],
            [
                'name' => 'Restaurant Admin',
                'password' => Hash::make('Admin@12345'),
                'role' => 'admin',
                'staff_status' => 'approved',
            ]
        );
    }
}

