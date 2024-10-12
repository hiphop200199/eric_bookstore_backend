<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\order;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Mail\Checkout;
use Illuminate\Support\Facades\Mail;
use App\Models\order_detail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $receiver_name = $request->receiverName;
        $receiver_tel = $request->receiverTel;
        $receiver_address = $request->receiverAddress;
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));//api key
        

        $items = cart::join('products', function ($join) use ($user_id) {
            $join->on('carts.product_id', '=', 'products.id')->where('carts.user_id', '=', $user_id);
        })->select(['carts.id','carts.product_id', 'carts.amount', 'products.name', 'products.price','products.image_source'])->get(); //撈購物車內所有的東西
        $lineItems = []; //stripe用來定義商品的資訊
        $totalPrice = 0;//總金額
        foreach ($items as $item) {
            $lineItems[] =  [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->name,
                        'images' => [$item->image_source]
                    ],
                    'unit_amount' => $item->price*100, //用美分計算，所以要*100轉換成美元
                ],
                'quantity' => $item->amount,
            ];
            $totalPrice += $item->price * $item->amount;
        }
        try{
            //建立結帳session
            $checkout_session = $stripe->checkout->sessions->create([
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => 'http://localhost:5173'.'/eric_bookstore'.'/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => 'http://localhost:5173'.'/eric_bookstore'.'/cancel',
            ]);
            //產生未付款訂單
            $order = order::create([
                'user_id'=> $user_id,
                'session_id'=> $checkout_session->id,
                'payment'=>'信用卡',
                'total_price'=>$totalPrice,
                'payment_status'=>'未付款',
                'invoice'=>'fdvg15d61d65grt1rgres',
                'receiver_name'=>$receiver_name,
                'receiver_tel'=>$receiver_tel,
                'receiver_address'=>$receiver_address,
                'pickup'=>'宅配',
                'pickup_status'=>'待出貨'
            ]);
            //產生訂單明細
            foreach($items as $item){
                order_detail::create([
                    'order_id'=> $order->id,
                    'product_id'=> $item->product_id,
                    'name'=> $item->name,
                    'amount'=> $item->amount,
                    'price'=> $item->price,
                    'discount'=>0,
                    'final_price'=> $item->price * $item->amount,
                ]);
            }
           //清除該使用者的購物車
           cart::where(['user_id'=>$user_id])->delete();
            return response()->json(['url'=> $checkout_session->url]);
           
        }catch (\Exception $e){
            return response()->json(['error'=> $e->getMessage()]);
        }
      
    }
    public function success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET_KEY'));//api key

        try {
            //核對session_id
            $session_id = $request->session_id;
            $session = $stripe->checkout->sessions->retrieve($session_id);
            if(! $session){
                return response()->json(['message'=>'Invalid Session ID']);
            }
            //找對應session_id的訂單
            $order = order::where('session_id','=', $session_id)->first();
            
            if(! $order){
               throw new NotFoundHttpException();
            }
            //更新訂單付款狀態
            $order->update(['payment_status'=>'已付款']);
            //付款成功後寄感謝信給客戶
            $user_id = $request->id;
            $user = User::where('id','=',$user_id)->first();
            Mail::to($user)->send(new Checkout($user));
            return response()->json(['message'=> 'done.']);
        }catch(NotFoundHttpException $e){
            throw $e;
        }
         catch (\Exception $e) {
          return response()->json(['error'=> $e->getMessage()]);
        }
    }
   
}
