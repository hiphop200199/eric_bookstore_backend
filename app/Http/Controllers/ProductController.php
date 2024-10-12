<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
    public function getProducts(Request $request)
    {
        $text = $request->text;
        if($text){
            $products = DB::table("products")->select(['id','image_source','name','price'])
            ->where('name','LIKE','%'.$text.'%')
            ->orWhere('introduction','LIKE','%'.$text.'%')
            ->paginate(10);
            return $products;
        }
        $products = Product::paginate(10);
        return $products;
    }
    public function getMonthlyNewProducts()
    {
        $products = Product::whereBetween('launched_date', [date('2024-10-01'), date('Y-m-d')])->paginate(10);
        return $products;
    }
    public function getPopularProducts()
    {
        $popular_products_list = DB::table('order_details')
        ->select('product_id',DB::raw('count(product_id)'))
        ->groupBy('product_id')
        ->orderBy('count(product_id)','DESC')
        ->take(5);
        $products = Product::select(['id','name','image_source','price'])
        ->joinSub($popular_products_list,'popular',function($join)
        {
            $join->on('products.id','=','popular.product_id');
        }
        )->get();
        return $products;
    }
    public function getProduct(Request $request)
    {
        $product = Product::find($request->id);
        return $product;
    }
}
