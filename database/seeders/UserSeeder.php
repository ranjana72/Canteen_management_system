<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::updateOrCreate(
            ['email' => 'admin@canteen.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin@123'),
                'role' => 'admin',
            ]
        );

        // Kitchen User
        User::updateOrCreate(
            ['email' => 'kitchen@canteen.com'],
            [
                'name' => 'Kitchen Staff',
                'password' => Hash::make('kitchen@123'),
                'role' => 'kitchen',
            ]
        );
    }
}
