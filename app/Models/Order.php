<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'outlet_id',
        'member_id',
        'table_id',
        'items',
        'subtotal'
    ];

    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class, 'outlet_id', 'id');
    }
    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
    public function outlet_table(): BelongsTo
    {
        return $this->belongsTo(OutletTable::class , 'table_id' , 'id');
    }
}
