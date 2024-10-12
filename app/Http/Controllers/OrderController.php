<?php

namespace App\Http\Controllers;

use App\Models\order;
use App\Http\Controllers\Controller;
use App\Models\order_detail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        //
    }
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
