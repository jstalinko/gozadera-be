<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemPoint extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'point',
        'stock'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
