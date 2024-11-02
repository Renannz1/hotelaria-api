<?php

use App\Http\Controllers\controllerapi;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelsController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(HotelController::class)->group(function () {
    Route::post('/hotel', 'detailHotel')->name('detailHotel');
    Route::get('/hotels', 'listHotels')->name('listHotels');
    Route::post('/add-hotel', 'addHotel')->name('addHotel');
    Route::put('/update-hotel', 'updateHotel')->name('updateHotel');
    Route::delete('/delete-hotel/{id}', 'deleteHotel')->name('deleteHotel');
});

Route::controller(RoomController::class)->group(function(){
    Route::post('/add-room/{id_hotel}', 'addRoom')->name('addRoom');
});

// rota api resource
Route::apiResource('hotel', HotelsController::class);



