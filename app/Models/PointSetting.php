<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'point',
        'minimum_spend'
    ];

    public static function getPoint($total){
        $pointSetting = PointSetting::all();
        $return = 0;
        foreach($pointSetting as $point){
            if($total >= $point->minimum_spend){
                $return= $point->point;
            }
        }
        return $return;
    }
}
