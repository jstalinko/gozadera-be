<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OutletTable extends Model
{
    use HasFactory;
    protected $fillable = [
        'outlet_id',
        'code',
        'max_pax',
        'price',
        'floor',
        'image',
        'status'
    ];

    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }
}
