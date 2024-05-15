<?php

namespace App\Http\Controllers\API;

use App\Helper\Helper;
use App\Models\Member;
use App\Models\RsvpGroup;
use App\Models\OutletTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RSVPController extends Controller
{
    public function rsvpMulti(Request $request)
    {
        $token = $request->bearerToken();
        $member = auth()->user();
        $data = json_decode($request->data, true);
        $member_id = $member->id;
        $outlet_id = $request->outlet_id;
        $invoice = 'RSVP'.Helper::invoice($member_id,$outlet_id);
        $total = 0;
        $payment_method = $request->payment_method;
        $payment_status = 'unpaid';
        foreach ($data as $key => $value) {
            $total += $value['price'];
            //update outlet table
            $outletTable = OutletTable::find($value['id']);
            $outletTable->status = 'on_hold';
            $outletTable->save(); 
        }

        $rsvpGroup = new RsvpGroup();
        $rsvpGroup->invoice = $invoice;
        $rsvpGroup->member_id = $member_id;
        $rsvpGroup->outlet_tables = json_encode($data);
        $rsvpGroup->total = $total;
        $rsvpGroup->payment_method = 'BCA';
        $rsvpGroup->payment_status = 'unpaid';
        $rsvpGroup->save();
        
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'RSVP success',
            'data' => $data
        ]);

    }
}
