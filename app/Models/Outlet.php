<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gmaps_url',
        'tagline',
        'phone',
        'address',
        'image',
        'is_karoke',
        'is_bar',
        'private_room',
        'active',
        'area_image'
    ];

    
}
