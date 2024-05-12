<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'promo_id',
        'name',
        'price',
        'description',
        'item_point',
        'category'
    ];
    public function promo()
    {
        return $this->hasOne(Promo::class);
    }
}
