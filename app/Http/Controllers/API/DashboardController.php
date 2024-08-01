<?php

namespace App\Http\Controllers\API;

use DB;
use App\Models\Rsvp;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Member;
use App\Models\BottleSaved;
use App\Models\MemberLevel;
use App\Models\PointSetting;
use Illuminate\Http\Request;
use App\Models\ProofTransfer;
use App\Models\RedeemHistory;
use App\Models\PaymentSetting;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function banner(): JsonResponse
    {
        $banners = Banner::where('status', 'active')->orderBy('id', 'desc')->get();

        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $banners;
        $data['message'] = 'Get all banners success';

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function top10spender(Request $request): JsonResponse
    {
        // count total order by member
        $top10spender = Order::select('member_id', \DB::raw('SUM(subtotal) as total_payment'))
            ->groupBy('member_id')
            ->orderBy('total_payment', 'desc')
            ->limit(10)
            ->get();
        // print with username and user level
        foreach ($top10spender as $spender) {
            $member = Member::find($spender->member_id);
            print_r($member);
            $member->total_transactions = $spender->total_payment;
            $member->save();
        }

        $top10spender2 = Member::select('username','total_transactions','email','id')->orderBy('total_transactions', 'desc')->limit(10)->get();
        foreach ($top10spender2 as $spender) {
            $spender->level = MemberLevel::seeLevelByTransaction($spender->total_transactions);
        }




        if (count($top10spender) < 1) {
            $datax = [];
        } else {
            $datax = $top10spender2;
        }
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $datax;
        $data['message'] = 'Get top 10 spender success';

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

    public function getPayments(Request $request): JsonResponse
    {
        $type = $request->type;
        $paymentSetting = PaymentSetting::where('type', $type)->get();

        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $paymentSetting;
        $data['message'] = 'Get payment setting success';

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function redeemHistory(): JsonResponse
    {
        $redeem = RedeemHistory::where('member_id', auth()->user()->id)->with('product')->with('redeem_point')->get();

        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $redeem;
        $data['message'] = 'Get redeem history success';
        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function profile(): JsonResponse
    {
        $member = Member::find(auth()->user()->id);
        $member->level = MemberLevel::seeLevel($member->id);
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $member;
        $data['message'] = 'Get profile success';
        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
    public function uploadProfile(Request $request): JsonResponse
    {
        $member = Member::find(auth()->user()->id);
        $fileImage = $request->file('image');
        $uploadPath = 'profile';



        $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'HEIC', 'heic', 'IMG', 'img'];
        $ext = $fileImage->getClientOriginalExtension();
        if (!in_array($ext, $allowedExt)) {
            $data['code'] = 400;
            $data['status'] = 'error';
            $data['message'] = 'File type not allowed';
            return response()->json($data, 400, [], JSON_PRETTY_PRINT);
        }

        $uploaded = $fileImage->store($uploadPath, 'public');

        $member->image = Storage::disk('public')->url($uploaded);
        $member->save();
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['message'] = 'Upload profile success';
        $data['filename'] = basename($uploaded);
        $data['img_url'] = Storage::disk('public')->url($uploaded);

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
    public function uploadReceipt(Request $request): JsonResponse
    {
        $member = Member::find(auth()->user()->id);
        $fileImage = $request->file('image');
        $uploadPath = 'receipt';



        $allowedExt = ['jpg', 'jpeg', 'png', 'pdf', 'gif', 'HEIC', 'heic', 'IMG', 'img'];
        $ext = $fileImage->getClientOriginalExtension();
        if (!in_array($ext, $allowedExt)) {
            $data['code'] = 400;
            $data['status'] = 'error';
            $data['message'] = 'File type not allowed';
            return response()->json($data, 400, [], JSON_PRETTY_PRINT);
        }

        $uploaded = $fileImage->store($uploadPath, 'public');

        $Proof = new ProofTransfer();
        $Proof->member_id = $member->id;
        $Proof->image = Storage::disk('public')->url($uploaded);
        $Proof->rsvp_id = $request->rsvp_id;
        $Proof->note = $request->note;
        $Proof->save();
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['message'] = 'Upload receipt success';
        $data['filename'] = basename($uploaded);
        $data['img_url'] = Storage::disk('public')->url($uploaded);

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }

    public function scanQr(Request $request): JsonResponse
    {
        $code = $request->code;
        $amount = $request->amount;
        $member = Member::find($code);
        $pointSetting = PointSetting::getPoint($amount);
        if ($member) {
            $member->point = $member->point + $pointSetting;
            $member->save();
            $data['code'] = 200;
            $data['status'] = 'success';
            $data['amount'] = $amount;
            $data['point']  = $pointSetting;
            $data['message'] = $pointSetting . ' points added to ' . $member->username;
            $data['data'] = $member;
            return response()->json($data, 200, [], JSON_PRETTY_PRINT);
        } else {
            $data['code'] = 400;
            $data['status'] = 'error';
            $data['message'] = 'Member not found';
            return response()->json($data, 400, [], JSON_PRETTY_PRINT);
        }
    }

    public function deactiveAccount()
    {

        $data['code'] = 200;
        $data['status'] = 'success';

        return response()->json($data, 200, [], JSON_PRETTY_PRINT);
    }
}
