<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$cart = cart::where()
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
    public function show(cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function removeItem(Request $request): Response
    {
        $item_id = $request->id;
        Cart::destroy($item_id);
        return response()->noContent();
    }
    public function getItems(Request $request)
    {
        $user_id = $request->id;
        $items = Cart::where("user_id","=", $user_id)->get();
        return $items;
    }
}
