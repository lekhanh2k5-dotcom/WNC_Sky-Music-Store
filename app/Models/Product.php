<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'author',
        'transcribed_by',
        'country_region',
        'file_path',
        'image_path',
        'price',
        'youtube_demo_url',
        'downloads_count',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'downloads_count' => 'integer',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    protected $attributes = [
        'downloads_count' => 0,
        'is_active' => true,
    ];
}
