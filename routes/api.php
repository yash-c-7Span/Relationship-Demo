<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Routes\Versions\V1;

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

Route::group(['prefix' => 'v1'], function(){
    Route::post('login', [AuthController::class, 'login']);
    Route::post('signup', [AuthController::class, 'signup']);

    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::group(['middleware' => "IsAdmin"], function(){
            Route::apiResource('users', UserController::class)->only('index', 'show', 'store', 'update', 'destroy');
            Route::apiResource('products', ProductController::class)->only('index', 'show', 'store', 'update', 'destroy');
            Route::apiResource('orders', OrderController::class)->only('index', 'show');
        });

        Route::get("product-list", [OrderController::class, 'productList']);
        Route::post("place-order", [OrderController::class, 'placeOrder']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


