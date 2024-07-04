<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        // Event saat creating
        static::creating(function ($category) {
            $category->slug = Str::slug($category->name); // Menggunakan helper Str::slug() untuk membuat slug dari nama
        });

        // Event saat updating
        static::updating(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
    protected $table = 'category';
}
