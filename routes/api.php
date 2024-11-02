<?php

use App\Http\Controllers\HotelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', [HotelController::class, 'test'])->name('test');
Route::post('/hotel', [HotelController::class, 'detailHotel'])->name('detailHotel');
Route::post('/add-hotel', [HotelController::class, 'addHotel'])->name('addHotel');


