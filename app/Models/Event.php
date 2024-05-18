<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'type',
        'name',
        'description',
        'image',
        'start_date',
        'end_date',
        'status'
    ];

    
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
