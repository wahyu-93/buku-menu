<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\TransactionController; 
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/{username}',[FrontendController::class,'index'])->name('index');

Route::get('/{username}/find-product',[FrontendController::class,'find'])->name('product.find');
Route::get('/{username}/find-product/result',[FrontendController::class,'findResult'])->name('product.find-result');

Route::get('/{username}/product/{id}',[FrontendController::class,'show'])->name('product.show');

Route::get('/{username}/cart', [TransactionController::class, 'cart'])->name('cart');
Route::get('/{username}/customer-information', [TransactionController::class, 'customerInformation'])->name('customer.information');

Route::post('/{username}/payment', [TransactionController::class, 'checkout'])->name('checkout');
Route::get('/transaction/success',[TransactionController::class, 'success'])->name('success');

