<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiktokLink extends Model
{
    use HasFactory;

    protected $table = 'tiktok_links';

    protected $fillable = [
        'title',
        'embed_code',
    ];
}
