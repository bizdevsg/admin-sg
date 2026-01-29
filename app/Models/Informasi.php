<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Informasi extends Model
{
    use HasFactory;

    protected $table = 'informasis';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($informasi) {
            if (empty($informasi->slug) && ! empty($informasi->title)) {
                $informasi->slug = Str::slug($informasi->title);
            }
        });

        static::updating(function ($informasi) {
            if (! empty($informasi->title)) {
                $informasi->slug = Str::slug($informasi->title);
            }
        });
    }
}
