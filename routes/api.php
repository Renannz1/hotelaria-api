<?php

use App\Http\Controllers\controllerapi;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// rotas api resource
Route::apiResource('/hotel', HotelController::class);
Route::apiResource('/rooms', RoomsController::class);

