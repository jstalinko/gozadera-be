<?php

namespace App\Http\Controllers\API;

use App\Models\Rsvp;
use App\Models\Outlet;
use App\Models\OutletTable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class OutletController extends Controller
{
    public function outlets(): JsonResponse
    {
        $outlets = Outlet::where('active',1)->get();
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $outlets;
        $data['message'] = 'Get all outlets success';

        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);

    }

    public function outlet_tables(Request $request): JsonResponse
    {
        $outlets = OutletTable::where('outlet_id',$request->outlet_id)->get();
        $getFloorOnly = OutletTable::select('floor')->where('outlet_id',$request->outlet_id)->groupBy('floor')->get();
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $outlets;
        $data['data_floor'] = $getFloorOnly;
        $data['message'] = 'Get all outlets success';

        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);

    }
    public function outletTableByFloor(Request $request): JsonResponse
    {
       
        $rsvp_date = date("Y-m-d", strtotime($request->rsvp_date));
        $rsvp = Rsvp::where('outlet_id',$request->outlet_id)->whereDate('rsvp_date',$rsvp_date)->get();
        $bookedIds = [];
        foreach($rsvp as $key => $value){
            $outlet_tables = json_decode($value->outlet_tables);
            foreach($outlet_tables as $key => $val){
                $bookedIds[] = $val->id;
            }
        }
        $outlets = OutletTable::where('outlet_id',$request->outlet_id)->where('floor',$request->floor)->whereNotIn('id',$bookedIds)->get();
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $outlets;
        $data['bookedId'] = $bookedIds;
        $data['rsvp'] = $rsvp;
        $data['datee'] = $rsvp_date;
        $data['message'] = 'Get all outlets success';

        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);
    }
    public function getFloor(Request $request): JsonResponse
    {
        $outlets = OutletTable::select('floor')->where('outlet_id',$request->outlet_id)->groupBy('floor')->get();
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $outlets;
        $data['message'] = 'Get all outlets success';

        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);
    }

    public function view(Request $request): JsonResponse
    {
        $outlet = Outlet::find($request->id);
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $outlet;
        $data['message'] = 'Get outlet success';
        $data['id'] = $request->id;

        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);

    }

    public function tableDetail(Request $request): JsonResponse
    {
        $outlet = OutletTable::where('code',$request->code)->first();
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $outlet;
        $data['message'] = 'Get outlet success';
        $data['code'] = $request->code;

        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);

    }
}
