<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

class OrderDetailApi extends Controller
{

    public function createOrder(Request $request)
    {
        try {
            $order = new Order();
            $order->status = $request->input('status');
            $order->user_id = $request->input('user_id');
            $order->save();

            $orderDetails = $request->input('order_details');

            foreach ($orderDetails as $detail) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->article_id = $detail['article_id'];
                $orderDetail->quantity = $detail['quantity'];
                $orderDetail->save();
            }

            return response()->json(['success' => true, 'orderId' => $order->id]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
