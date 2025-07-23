<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Console\Migrations\ResetCommand;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function cart(Request $request)
    {
        $store = User::with('products')->where('username', $request->username)->first();
        
        if(!$store){
            abort(404);
        };

        return view('pages.cart', compact('store'));
    }

    public function customerInformation(Request $request)
    {
        $store = User::with('products')->where('username', $request->username)->first();
        
        if(!$store){
            abort(404);
        };

        return view('pages.customer-information', compact('store'));
    }
}
