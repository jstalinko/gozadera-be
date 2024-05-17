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
        'category',
        'stock',
        'image'
    ];
    public function promo()
    {
        return $this->hasOne(Promo::class , 'id' , 'promo_id');
    }
}
