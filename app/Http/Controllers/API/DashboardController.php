<?php

namespace App\Http\Controllers\API;

use DB;
use App\Models\Order;
use App\Models\Promo;
use App\Models\Banner;
use App\Models\Member;
use App\Models\BottleSaved;
use App\Models\MemberLevel;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

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

    public function promo(Request $request): JsonResponse
    {
        $period = $request->period;
        $promos = Promo::where('status', 'active')->where('promo_period', $period)->with('product')->get();

        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $promos;
        $data['message'] = 'Get all promos success';

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function myBottles(Request $request): JsonResponse
    {

        $myBottles = BottleSaved::where('member_id', $request->member_id)->with('product')->with('outlet')->get();
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $myBottles;
        $data['count'] = $myBottles->count();
        $data['message'] = 'Get my bottles success';

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $member = Member::find(auth()->user()->id);
        //check username or email exist
        if ($request->username) {
            $checkUsername = Member::where('username', $request->username)->where('id', '!=', $member->id)->first();
            if ($checkUsername) {
                $data['code'] = 400;
                $data['status'] = 'error';
                $data['message'] = 'Username already exist';
                return response()->json($data, 400, [], JSON_PRETTY_PRINT);
            }
        }
        if ($request->email) {
            $checkEmail = Member::where('email', $request->email)->where('id', '!=', $member->id)->first();
            if ($checkEmail) {
                $data['code'] = 400;
                $data['status'] = 'error';
                $data['message'] = 'Email already exist';
                return response()->json($data, 400, [], JSON_PRETTY_PRINT);
            }
        }
        if ($request->newPassword != null) {
            $currentPassword = $member->password;
            $requestCurrentPassword = $request->currentPassword;
            $requestNewPassword = $request->newPassword;
            if (Hash::check($requestCurrentPassword, $currentPassword)) {
                $member->password = Hash::make($requestNewPassword);
            } else {
                $data['code'] = 400;
                $data['status'] = 'error';
                $data['message'] = 'Current password is wrong';
                return response()->json($data, 400, [], JSON_PRETTY_PRINT);
            }
        }

        $member->username = $request->username;
        $member->phone = $request->phone;
        $member->email = $request->email;
        $member->address = $request->address;
        $member->save();

        $data['code'] = 200;
        $data['status'] = 'success';
        $data['message'] = 'Update profile success';
        $data['data'] = $request->all();

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
}
