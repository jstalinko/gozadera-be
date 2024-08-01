<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProofTransfer extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'member_id',
        'rsvp_id',
        'order_id',
        'image',
        'note'
];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id','id');
    }
    public function rsvp()
    {
        return $this->belongsTo(Rsvp::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
