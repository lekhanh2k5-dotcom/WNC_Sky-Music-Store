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
        User::create([
            'name' => 'Nguyen Van A',
            'email' => 'user1@example.com',
            'password' => Hash::make('password123'),
        ]);
        User::create([
            'name' => 'Tran Thi B',
            'email' => 'user2@example.com',
            'password' => Hash::make('password123'),
        ]);
        User::create([
            'name' => 'Le Van C',
            'email' => 'user3@example.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
