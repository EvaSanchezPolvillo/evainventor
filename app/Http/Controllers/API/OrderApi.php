<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\UserControlerApi;
use App\Models\OrderDetail;
use App\Models\Article;



class OrderApi extends Controller
{

    public function saveOrderDetail(Request $request)
    {
        $orderDetails = $request->all();


//        array:2 [ // app/Http/Controllers/API/OrderApi.php:19
//            "idUsuario" => "1"
//            "orderDetail" => array:2 [
//                0 => array:2 [
//                    "article_id" => "5"
//                  "quantity" => "1"
//                ]
//                1 => array:2 [
//                    "article_id" => "6"
//                  "quantity" => "2"
//                ]
//            ]
//        ]
//


        try {
            $order = new Order();
            //Esto se hace dinamico para coger el estado inicial desde el entorno
            $order->status = env('STATUS_INITIAL', 1);

                $order->user_id = $orderDetails['idUsuario'];


            $response = $order->save();

            if($response) {

                $orderDetails = $request->input('orderDetail');

                foreach ($orderDetails as $detail) {
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->article_id = $detail['article_id'];
                    $orderDetail->quantity = $detail['quantity'];
                    $orderDetail->save();

                    $article = Article::find($detail['article_id']);
                    $article->stock -= $detail['quantity'];
                    $article->save();
                }
            }

            return response()->json(['success' => true, 'orderId' => $order->id]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }
    }
}
