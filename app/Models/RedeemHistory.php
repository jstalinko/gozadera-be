<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemHistory extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'member_id',
        'product_id',
        'redeem_point_id',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id','id');
    }
    public function redeem_point()
    {
        return $this->belongsTo(RedeemPoint::class);
    }
}
