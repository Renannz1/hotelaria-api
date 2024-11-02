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


}
