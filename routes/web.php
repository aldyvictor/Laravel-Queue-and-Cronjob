<?php

use Illuminate\Support\Facades\Route;
use App\Jobs\SendNotification;
use App\Jobs\ProcessPayment;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    foreach (range(1, 100) as $i) {
        SendNotification::dispatch();
    }

    ProcessPayment::dispatch()->onQueue('payments');
    return view('welcome');
});
