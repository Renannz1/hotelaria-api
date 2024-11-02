<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function test(){
        return response()->json([
                'status' => 'ok',
                'message' => 'API rodando com sucesso!',
            ], 200);
    }

    public function addHotel(Request $request){
        $hotel = New Hotel();
        $hotel->name = $request->name;
        $hotel->save();

        return response()->json([
            'status' => 'ok',
            'mensagem' => 'Hotel adicionado com sucesso!',
            'dados' => $hotel,
        ], 200);
    }

    public function detailHotel(Request $request){
        if(!$request->id){
            response()->json([
                'status' => 'error',
                'mensagem' => 'ID do hotel necessário.',
            ], 400);
        }

        $hotel = Hotel::find($request->id);

        if(!$hotel){
            response()->json([
                'status' => 'error',
                'mensagem' => 'Hotel não encontrado.',
            ], 400);
        }

        return response()->json([
            'status' => 'ok',
            'mensagem' => 'Hotel encontrado.',
            'dados' => $hotel,
        ], 200);
    }

    public function listHotels(){
        $hotels = Hotel::all();

        return response()->json([
            'status' => 'ok',
            'mensagem' => 'Lista de Hoteis ativos.',
            'dados' => $hotels,
        ], 200);
    }

}
