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
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $outlets;
        $data['message'] = 'Get all outlets success';

        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);

    }
}
