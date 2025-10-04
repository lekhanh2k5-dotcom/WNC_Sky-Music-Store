<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Bài nhạc Việt Nam
        Product::create([
            'name' => 'Lạc Trôi',
            'author' => 'Sơn Tùng MTP',
            'transcribed_by' => 'Piano Việt Studio',
            'country_region' => 'Việt Nam',
            'file_path' => 'songs/vietnam/lac-troi.json',
            'price' => 25000,
            'youtube_demo_url' => 'https://www.youtube.com/watch?v=DrY_d0X5z5s',
            'downloads_count' => 156,
            'is_active' => true
        ]);

        // Bài nhạc Hàn Quốc
        Product::create([
            'name' => 'Spring Day',
            'author' => 'BTS',
            'transcribed_by' => 'K-Piano Master',
            'country_region' => 'Hàn Quốc',
            'file_path' => 'songs/korea/spring-day.json',
            'price' => 30000,
            'youtube_demo_url' => 'https://www.youtube.com/watch?v=xEeFrLSkMm8',
            'downloads_count' => 342,
            'is_active' => true
        ]);

        // Bài nhạc Nhật Bản
        Product::create([
            'name' => 'Kimi no Na wa (Your Name)',
            'author' => 'RADWIMPS',
            'transcribed_by' => 'Anime Piano Collection',
            'country_region' => 'Nhật Bản',
            'file_path' => 'songs/japan/kimi-no-na-wa.json',
            'price' => 35000,
            'youtube_demo_url' => 'https://www.youtube.com/watch?v=PDSkFeMVNFs',
            'downloads_count' => 89,
            'is_active' => true
        ]);
    }
}
