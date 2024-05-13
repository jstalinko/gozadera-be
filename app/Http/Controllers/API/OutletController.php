<?php

namespace App\Http\Controllers\API;

use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\OutletTable;

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
        $outlets = OutletTable::where('outlet_id',$request->outlet_id)->where('floor',$request->floor)->where('status' , 'available')->get();
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $outlets;
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
