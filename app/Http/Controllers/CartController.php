<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CartController extends Controller
{
    
    

    

    public function addItem(Request $request):JsonResponse
    {
        $item_id = $request->id;
        $member_id = $request->memberId;
        $item = cart::where([['product_id',$item_id],['user_id',$member_id]])->first();
        if ($item) {
            return response()->json('already added.');
        }else{
            cart::create([
                'user_id'=> $member_id,
                'product_id'=> $item_id,
                'amount'=>1
            ]);
            return response()->json('added.');
        }
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
       $items = DB::table('products')->join('carts',function($join) use ($user_id){
        $join->on('products.id','=','carts.product_id')
        ->where('carts.user_id','=', $user_id);
       })->select(['products.id','products.image_source','products.name','products.price','carts.amount'])
       ->get();
       return $items;
    }
}
