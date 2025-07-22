<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if(!$store){
            abort(404);
        };

        $populers = Product::where('user_id', $store->id)->where('is_popular', true)->take(10)->get();
        $products = Product::where('user_id', $store->id)->where('is_popular', false)->get();

        return view('pages.index', compact('store', 'populers','products'));
    }

    public function show(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if(!$store){
            abort(404);
        };

        $product = Product::where('id', $request->id)->first();

        if(!$product){
            abort(404);
        };

        return view('pages.product-details', compact('store', 'product'));
    }

    public function find(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if(!$store){
            abort(404);
        };

        $categories = ProductCategory::where('user_id', $store->id)->get();

        return view('pages.find-product',compact('store', 'categories'));
    }

    public function findResult(Request $request)
    {
        $store = User::where('username', $request->username)->first();

        if(!$store){
            abort(404);
        };

        $products = Product::where('user_id', $store->id);

        // cari berdasarkan category
        if(isset($request->category)){
            $products = Product::where('product_category_id', $request->category);
        };

        // cari berdasarkan search atau ketik manual
        if(isset($request->search)){
            $products = Product::where('user_id', $store->id)
                                ->where('name','like','%'.$request->search.'%');
        };

        $products = $products->get();

        return view('pages.find-result', compact('store', 'products'));
    }
}
