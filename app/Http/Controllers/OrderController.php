<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Http\Controllers\Controller;
use App\Models\order_detail;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function getOrders(Request $request)
    {
        $id = $request->id;
        $orders = order::select('id','payment_status','total_price','pickup_status','created_at')->where('user_id','=', $id)->get();
        return $orders;
    }
    public function getOrder(Request $request)
    {
       $id = $request->id;
       $order = order_detail::join('products',function($join){
        $join->on('order_details.product_id','=','products.id');
       })->select('order_details.id','order_details.name','order_details.amount','order_details.price','order_details.discount','order_details.final_price','products.image_source')->where('order_id','=', $id)->get();
       return $order;
    }
}
