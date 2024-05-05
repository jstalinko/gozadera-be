<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Member extends Model
{
    use HasFactory;
    use HasApiTokens;
    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
        'address',
        'point',
        'status',
        'image'
    ];
}
