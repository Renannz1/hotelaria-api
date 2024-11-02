<?php

use App\Http\Controllers\HotelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/hotel', [HotelController::class, 'detailHotel'])->name('detailHotel');
Route::get('/hotels', [HotelController::class, 'listHotels'])->name('listHotels');
Route::post('/add-hotel', [HotelController::class, 'addHotel'])->name('addHotel');
Route::put('/update-hotel', [HotelController::class, 'updateHotel'])->name('updateHotel');
Route::delete('/delete-hotel/{id}', [HotelController::class, 'deleteHotel'])->name('deleteHotel');
