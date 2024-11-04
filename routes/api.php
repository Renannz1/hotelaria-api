<?php

use App\Http\Controllers\controllerapi;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/hotel', HotelController::class);
Route::apiResource('/room', RoomController::class);
Route::apiResource('/reserve', ReserveController::class);
Route::apiResource('/coupon', CouponController::class);

