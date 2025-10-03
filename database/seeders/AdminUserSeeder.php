<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo admin user mặc định
        User::updateOrCreate(
            ['email' => 'admin@skymusic.com'],
            [
                'name' => 'Sky Music Admin',
                'email' => 'admin@skymusic.com',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Tạo thêm một admin user khác
        User::updateOrCreate(
            ['email' => 'lekhanh@skymusic.com'],
            [
                'name' => 'Lê Khánh',
                'email' => 'lekhanh@skymusic.com',
                'password' => Hash::make('lekhanh123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        echo "✅ Admin users created successfully!\n";
        echo "📧 admin@skymusic.com | 🔑 admin123\n";
        echo "📧 lekhanh@skymusic.com | 🔑 lekhanh123\n";
    }
}
