<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    
    public function orderProduct(Request $request): JsonResponse
    {
        $outlet_id = $request->outlet_id;
        $table_id = $request->table_id;
        $member_id = $request->member_id;
        $order_items = $request->items;
        $subtotal = 0;
        foreach($order_items as $item){
            $subtotal += $item['price'] * $item['qty'];
        }
        $order = new Order();
        $order->outlet_id = $outlet_id;
        $order->table_id = $table_id;
        $order->member_id = $member_id;
        $order->subtotal = $subtotal;
        $order->items = json_encode($order_items);
        $order->save();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => 'Order success',
            'data' => [
                'order_id' => $order->id,
                'subtotal' => $subtotal
            ]
            ]);
    }
}
