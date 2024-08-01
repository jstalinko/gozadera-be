<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'minumum_spend'
    ];

    public static function seeLevel($member_id)
    {
        $costs = Order::where('member_id', $member_id)->sum('subtotal');
        $level = MemberLevel::where('minumum_spend', '<=', $costs)->orderBy('minumum_spend', 'desc')->first();
        return $level->name;
    }

    public static function seeLevelByTransaction($total)
    {
        $level = MemberLevel::where('minumum_spend','<=' , $total)->orderBy('minumum_spend','desc')->first();
        return $level->name;
    }
}
