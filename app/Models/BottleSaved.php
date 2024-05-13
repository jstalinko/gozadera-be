<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BottleSaved extends Model
{
    use HasFactory;
    protected $fillable = [
        'member_id',
        'outlet_id',
        'product_id',
        'qty',
        'status',
        'expired_at',
        'note',
        'taken_at',
        'cancelled_at',
    ];
    public function member(){
        return $this->belongsTo(Member::class);
    }
    public function outlet(){
        return $this->belongsTo(Outlet::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
