<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CartController extends Controller
{





    public function addItem(Request $request): JsonResponse
    {
        $item_id = $request->id;
        $member_id = $request->memberId;
        $item = cart::where([['product_id', $item_id], ['user_id', $member_id]])->first();
        if ($item) {
            return response()->json('already added.');
        } else {
            cart::create([
                'user_id' => $member_id,
                'product_id' => $item_id,
                'amount' => 1
            ]);
            return response()->json('added.');
        }
    }
    public function editItem(Request $request): Response
    {
        $item_id = $request->id;
        $amount = $request->amount;
        DB::table('carts')->where('id', '=', $item_id)->update(['amount' => $amount]);
        return response()->noContent();
    }
    public function removeItem(Request $request): Response
    {
        $item_id = $request->id;
        Cart::destroy($item_id);
        return response()->noContent();
    }
    public function getItems(Request $request)
    {
        $user_id = $request->id;
        $items = DB::table('products')->join('carts', function ($join) use ($user_id) {
            $join->on('products.id', '=', 'carts.product_id')
                ->where('carts.user_id', '=', $user_id);
        })->select(['carts.id', 'products.image_source', 'products.name', 'products.price', 'carts.amount'])
            ->get();
        return $items;
    }
    public function checkout(Request $request)
    {
        $user_id = $request->id;
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));
        //Stripe::setApiKey(env('STRIPE_SECRET_KEY')); //api key

        $items = cart::join('products', function ($join) use ($user_id) {
            $join->on('carts.product_id', '=', 'products.id')->where('carts.user_id', '=', $user_id);
        })->select(['carts.id', 'carts.amount', 'products.name', 'products.price','products.image_source'])->get(); //撈購物車內所有的東西
        $lineItems = []; //stripe用來定義商品的資訊
        foreach ($items as $item) {
            $lineItems[] =  [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->name,
                        'images' => [$item->image_source]
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => $item->amount,
            ]];
        }
        try{
            $checkout_session = $stripe->checkout->sessions->create([
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => env('FRONTEND_URL')."/success?session_id={CHECKOUT_SESSION_ID}",
                'cancel_url' => env('FRONTEND_URL').'/cancel',
            ]);
            return response()->json(['url'=> $checkout_session->url]);
           
        }catch (\Exception $e){
            return response()->json(['error'=> $e->getMessage()]);
        }
      
    }
}
