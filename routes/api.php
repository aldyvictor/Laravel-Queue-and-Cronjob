<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Transaction
Route::post('/checkout', [TransactionController::class, 'checkout'])->name('transaction.checkout');
Route::get('/transaction-history/{id}', [TransactionController::class, 'userHistory']);
Route::put('/payment-confirmation/{id}/{user_id}', [TransactionController::class, 'paidOrder']);

// Product
Route::post('/add-product', [ProductController::class, 'store']);

