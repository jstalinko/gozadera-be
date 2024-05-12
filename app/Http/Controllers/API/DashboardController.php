<?php

namespace App\Http\Controllers\API;

use App\Models\Banner;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\MemberLevel;
use App\Models\Order;
use DB;

class DashboardController extends Controller
{
    public function banner(): JsonResponse
    {
        $banners = Banner::where('status', 'active')->get();

        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $banners;
        $data['message'] = 'Get all banners success';

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function top10spender(): JsonResponse
    {
        // count total order by member
        $top10spender = Order::select('member_id', DB::raw('SUM(subtotal) as total_payment'))
            ->groupBy('member_id')
            ->orderBy('total_payment', 'desc')
            ->limit(10)
            ->get();
            // print with username and user level
        foreach ($top10spender as $spender) {
            $member = Member::find($spender->member_id);
            $spender->username = $member->username;
            $spender->level = MemberLevel::seeLevel($spender->member_id);
        }
        

        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $top10spender;
        $data['message'] = 'Get top 10 spender success';

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
}
