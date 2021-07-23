<?php

use App\Http\Controllers\PayPalController;
use App\Http\Controllers\PurchaseController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('create-payment/{id}', [PayPalController::class, 'createPayment']);
Route::post('execute-payment/{id}/capture', [PayPalController::class, 'executePayment']);