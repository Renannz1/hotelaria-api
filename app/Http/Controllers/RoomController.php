<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function addRoom(Request $request, $hotel_id){
        $hotel = Hotel::find($hotel_id);
        if (!$hotel){
            return response()->json([
                'mensagem' => 'Você está tentando associar o quarto a um Hotel que nao existe.'
            ], 400);
        }

        $room = new Room();
        $room->name = $request->name;
        $hotel->rooms()->save($room);

        return response()->json([
            'mensagem' => 'Quarto criado com sucesso.',
            'dados' => $room,
        ], 201);
    }
}
