<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);


Route::middleware(['auth:api'])->group(function () {

    Route::delete('orders',[OrderController::class, 'clearExistOrders']);
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('orders',[OrderController::class,'getOrders']);
    Route::get('orders/{order}',[OrderController::class, 'buyOrder']);
    Route::get('leaderboard',[UserController::class,'getLeaderBoard']);
});
