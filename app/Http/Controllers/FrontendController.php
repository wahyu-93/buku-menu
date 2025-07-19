<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
}
