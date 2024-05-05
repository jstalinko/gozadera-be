<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

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
}
