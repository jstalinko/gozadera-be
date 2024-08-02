<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
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

    public function myTicket(Request $request): JsonResponse
    {
        $filter = ($request->filter !== '') ? $request->filter : null;
        $member = auth()->user();
        $thirtyDaysAgo = date('Y-m-d', strtotime('-30 days'));
        $sevenDaysAgo = date('Y-m-d', strtotime('-7 days'));
        $nintyDaysAgo = date('Y-m-d', strtotime('-90 days'));

        if ($filter == null) {
            $rsvp = Rsvp::where('member_id', $member->id)->orderBy('created_at', 'desc')->with('payments')->with('proofTransfer')->orderBy('id', 'desc')->get();
        } else {
            $query = Rsvp::where('member_id', $member->id);

            if ($filter === '30day') {
                $query->where('created_at', '>=', Carbon::now()->subDays(30)->startOfDay());
            } elseif ($filter === '90day') {
                $query->where('created_at', '>=', Carbon::now()->subDays(90)->startOfDay());
            } elseif ($filter === 'today') {
                $query->where('created_at', '=', Carbon::now());
            }
            
            $rsvp = $query->orderBy('created_at', 'desc')
                ->with(['payments', 'proofTransfer'])
                ->orderBy('id', 'desc')
                ->get();
        }
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'My Ticket',
            'filter' => $filter,
            'data' => $rsvp
        ]);
    }

    public function scanQrRsvp(Request $request): JsonResponse
    {
        $invoice = $request->invoice;
        $rsvp = Rsvp::where('invoice', $invoice)->first();
        if ($rsvp) {
            if ($rsvp->payment_status == 'paid') {

                if ($rsvp->pax_lefet == 0 || $rsvp->pax_left < 1) {
                    $data['status'] = 'error';
                    $data['message'] = 'Failed, Pax left is 0 !';
                    return response()->json($data, 200, [], JSON_PRETTY_PRINT);
                }
                $rsvp->status = 'check_in';
                $rsvp->pax_left = $rsvp->pax_left - 1;
                $rsvp->save();
                $data['code'] = 200;
                $data['status'] = 'success';
                $data['message'] = 'Success check-in ( Pax left : ' . $rsvp->pax_left . ' )';
                $data['data'] = $rsvp;
                return response()->json($data, 200, [], JSON_PRETTY_PRINT);
            } else {
                $data['status'] = 'error';
                $data['message'] = 'This rsvp is not paid yet or not verified';
                return response()->json($data, 400, [], JSON_PRETTY_PRINT);
            }
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Invoice not found';
            return response()->json($data, 400, [], JSON_PRETTY_PRINT);
        }
    }

    public function detail(Request $request)
    {
        $id = $request->id;
        $member = auth()->user();
        $rsvp = Rsvp::where('member_id', $member->id)->where('id', $id)->with('payments')->with('proofTransfer')->first();
        if (!$rsvp) {
            return response()->json([
                'code' => 404,
                'status' => 'error',
                'message' => 'not found'
            ]);
        }
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'My Ticket',
            'data' => $rsvp
        ]);
    }
}
