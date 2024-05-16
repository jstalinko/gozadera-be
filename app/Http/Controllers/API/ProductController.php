<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use App\Models\RedeemPoint;
use Illuminate\Http\Request;
use App\Models\RedeemHistory;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Member;

class ProductController extends Controller
{
    public function show(): JsonResponse
    {
        $products = Product::all();
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $products;
        $data['message'] = 'Get all products success';

        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);

    }

    public function view($id): JsonResponse
    {
        $product = Product::find($id);
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $product;
        $data['message'] = 'Get product success';

        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);
    }
    public function category($category): JsonResponse
    {
        $products = Product::where('category' , $category)->get();
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $products;
        $data['message'] = 'Get product by category success';

        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);
    }

    public function productRedeemables(): JsonResponse
    {
        $products = RedeemPoint::with('product')->where('stock' , '>' , 0)->get();
        
        $data['code'] = 200;
        $data['status'] = 'success';
        $data['data'] = $products;
        $data['message'] = 'Get product redeemables success';

        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);
    }

    public function redeem(Request $request): JsonResponse
    {
        $product_id = $request->product_id;
        $member_id = auth()->user()->id;
        $redeem_point_id = $request->redeem_id;
        $member = Member::find($member_id);
        $redeemPoint = RedeemPoint::find($redeem_point_id);
        $redeemPoint->stock = $redeemPoint->stock - 1;
        if($member->point < $redeemPoint->point){
            $data['code'] = 400;
            $data['status'] = 'error';
            $data['message'] = 'Point not enough';
            return response()->json($data , 400 , [] , JSON_PRETTY_PRINT);
        }

        $redeem = new RedeemHistory();
        $redeem->member_id = $member_id;
        $redeem->product_id = $product_id;
        $redeem->redeem_point_id = $redeem_point_id;
        $redeem->status = 'pending';
        

        
        $member->point = $member->point - $redeemPoint->point;
        
        $redeemPoint->save();
        $member->save();
        $redeem->save();
       


        $data['code'] = 200;
        $data['status'] = 'success';
        $data['userpoint'] = $member->point;
        $data['message'] = 'Redeem success';
        return response()->json($data , 200 , [] , JSON_PRETTY_PRINT);
    }
}
