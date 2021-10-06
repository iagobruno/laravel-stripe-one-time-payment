<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DownloadBookController;
use App\Http\Controllers\PurchaseController;
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

Route::post('/checkout', [PurchaseController::class, 'redirectToCheckout'])->name('checkout')->middleware('auth');

Route::get('/checkout/callback', [PurchaseController::class, 'callback'])->name('checkout.callback')->middleware('auth');
