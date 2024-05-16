<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rsvp extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'outlet_id',
        'pax',
        'table_id',
        'status',
        'subtotal',
        'payment_status',
        'table_price'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function payments()
    {
        return $this->hasMany(PaymentSetting::class , 'type' , 'payment_method');
    }
}
