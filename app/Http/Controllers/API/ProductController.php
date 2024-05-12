<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\RedeemPoint;

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
}
