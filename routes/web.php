<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DownloadBookController;
use Illuminate\Support\Facades\Route;

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

Route::view('/', 'app');

Route::post('/auth', AuthController::class)->name('auth');

Route::middleware('auth')->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'redirect'])->name('checkout');

    Route::get('/checkout/callback', [CheckoutController::class, 'callback'])->name('checkout.callback');

    Route::post('/download', DownloadBookController::class)->name('download');
});
