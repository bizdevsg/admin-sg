<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';

    protected $fillable = [
        'web_title',
        'web_description',
        'address',
        'maps_link',
        'link_pengaduan',
        'phone',
        'fax',
        'email'
    ];
}
