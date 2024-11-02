<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function status(){
        return response()->json([
                'status' => 'ok',
                'message' => 'API rodando com sucesso!',
            ], 200);
    }

    public function addHotel(Request $request){
        $client = New Hotel();
        $client->name = $request->name;
        $client->save();

        return response()->json([
            'status' => 'ok',
            'mensagem' => 'Hotel adicionado com sucesso!',
            'dados' => $client,
        ], 200);
    }


}
