<?php

namespace App\Http\Controllers\API;

use App\Models\Rsvp;
use App\Helper\Helper;
use App\Models\Member;
use App\Models\RsvpGroup;
use App\Models\OutletTable;
use App\Models\Transaction;
use App\Models\PointSetting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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
        $invoice = 'RSVP' . Helper::invoice($member_id, $outlet_id);
        $total = 0;
        $totalPax = 0;
        foreach ($data as $key => $value) {
            $total += $value['price'];
            //update outlet table
            $outletTable = OutletTable::find($value['id']);
            // push booked_date to outlet table
            $booked_date = json_decode($outletTable->booked_date, true);
            $booked_date[] = $request->rsvp_date;
            $outletTable->booked_date = json_encode($booked_date); 
            $outletTable->save();

            $totalPax += $value['max_pax'];
        }
        $newDate = date("Y-m-d H:i:s", strtotime($request->rsvp_date));
        $rsvpGroup = new Rsvp();
        $rsvpGroup->invoice = $invoice;
        $rsvpGroup->member_id = $member_id;
        $rsvpGroup->outlet_id = $outlet_id;
        $rsvpGroup->outlet_tables = json_encode($data);
        $rsvpGroup->total = $total;
        $rsvpGroup->subtotal = $total;
        $rsvpGroup->status = 'waiting_payment';
        $rsvpGroup->payment_method = $request->payment_method;
        $rsvpGroup->payment_status = 'unpaid';
        $rsvpGroup->pax_left = $totalPax;
        $rsvpGroup->rsvp_date = $newDate;
        $rsvpGroup->save();

        // get point
        // $member = Member::find($member_id);
        // $pointSetting = PointSetting::getPoint($total);
        // $member->point += $pointSetting;
        // $member->save();

        
        
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'RSVP success',
            'data' => $data
        ]);
    }

    public function myTicket(): JsonResponse
    {
        $member = auth()->user();
        $rsvp = Rsvp::where('member_id', $member->id)->orderBy('created_at', 'desc')->with('payments')->with('proofTransfer')->get();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'My Ticket',
            'data' => $rsvp
        ]);
    }
}
