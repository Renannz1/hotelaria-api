<?php

use App\Http\Controllers\HotelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', [HotelController::class, 'status']);
Route::post('/add-hotel', [HotelController::class, 'addHotel']);

