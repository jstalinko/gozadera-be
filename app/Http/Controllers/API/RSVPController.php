<?php

namespace App\Http\Controllers\API;

use App\Helper\Helper;
use App\Models\Member;
use App\Models\RsvpGroup;
use App\Models\OutletTable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rsvp;
use Illuminate\Http\JsonResponse;
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
            $outletTable->status = 'on_hold';
            $outletTable->save();

            $totalPax += $value['max_pax'];
        }

        $rsvpGroup = new Rsvp();
        $rsvpGroup->invoice = $invoice;
        $rsvpGroup->member_id = $member_id;
        $rsvpGroup->outlet_id = $outlet_id;
        $rsvpGroup->outlet_tables = json_encode($data);
        $rsvpGroup->total = $total;
        $rsvpGroup->subtotal = $total;
        $rsvpGroup->status = 'issued';
        $rsvpGroup->payment_method = 'BCA';
        $rsvpGroup->payment_status = 'unpaid';
        $rsvpGroup->pax_left = $totalPax;
        $rsvpGroup->rsvp_date = $request->rsvp_date;
        $rsvpGroup->save();

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
        $rsvp = Rsvp::where('member_id', $member->id)->orderBy('created_at', 'desc')->get();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'My Ticket',
            'data' => $rsvp
        ]);
    }
}
