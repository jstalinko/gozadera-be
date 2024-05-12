<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BottleSaved extends Model
{
    use HasFactory;

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
