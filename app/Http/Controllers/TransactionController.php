<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
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

    public function checkout(Request $request)
    {
        // cek toko
        $store = User::with('products')->where('username', $request->username)->first();
        
        if(!$store){
            abort(404);
        };

        // simpan transaksi
        $transaction = $store->transactions()->create([
            'code'  => 'TRX-' . mt_rand(10000,99999),
            'name'  => $request->name,
            'no_telp'       => $request->phone_number,
            'table_number'  => $request->table_number,
            'payment_method'=> $request->payment_method,
            'total_price'   => '0',
            'status'        => 'pending'
        ]);

        // simpan detail transaksi
        $carts = json_decode($request->cart, true);

        foreach($carts as $cart){
            $transaction->transactionDetails()->create([
                'product_id' => $cart['id'],
                'quantity'   => $cart['qty'],
                'note'       => $cart['notes'],
            ]);
        }

        // mendapatkan total price
        $details = TransactionDetail::with('product')
            ->where('transaction_id', $transaction->id)
            ->get();

        $totalPrice = $details->sum(function ($detail) {
            $product = $detail->product;
            if (!$product) return 0;

            return $product->price * $detail->quantity;
        });

        // update total price di tabel transaction
        $transaction->update([
            'total_price'   => $totalPrice
        ]);


        if($request->payment_method === 'cash'){
            return redirect()->route('success',['username' => $store->username, 'order_id' => $transaction->code]);        
        }
    }

    public function success(Request $request)
    {
        $transaction = Transaction::where('code', $request->order_id)->first();
        $store = User::where('username', $request->username)->first();

        if(!$store){
            abort(404);
        };

        return view('pages.success', compact('store', 'transaction'));

    }
}