<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberLevel extends Model
{
    use HasFactory;

    public static function seeLevel($member_id)
    {
        $costs = Order::where('member_id', $member_id)->sum('subtotal');
        $level = MemberLevel::where('minumum_spend', '<=', $costs)->orderBy('minumum_spend', 'desc')->first();
        return $level->name;
    }
}
