<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomsController extends Controller
{

    public function index()
    {
        $rooms = Room::all();

        return response()->json([
            'dados' => $rooms,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'name' => 'required|string'
        ]);

        $hotel = Hotel::find($request->hotel_id);

        $room = new Room();
        $room->name = $request->name;

        $hotel->rooms()->save($room);

        return response()->json([
            'mensagem' => 'Quarto criado com sucesso.',
        ], 201);
    }

    public function show(string $id)
    {
        $hotel = Hotel::find($id);

        if(!$hotel){
            return response()->json([
                'mensagem' => 'Quarto não encontrado.',
            ], 400);
        }

        return response()->json([
            'dados' => $hotel
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $room = Room::find($id);

        if (!$room){
            return response()->json([
                'mensagem' => 'Quarto não encontrado.'
            ], 400);
        }


        $request->validate([
            'name' => 'required|string'
        ]);

        $room->name = $request->name;
        $room->save();

        return response()->json([
            'mensagem' => 'Quarto atualizado.'
        ]);
    }

}
