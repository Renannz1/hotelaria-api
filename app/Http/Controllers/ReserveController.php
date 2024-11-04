<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Reserve;
use App\Models\Room;
use Illuminate\Http\Request;

class ReserveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'total' => 'required|numeric'
        ]);

        $room = Room::find($request->room_id);

        if(!$room){
            return response()->json([
                'mensagem' => 'quarto nao econtrado.'
            ], 404);
        }

        $hotel_id = $room->hotel_id;

        $reserve = new Reserve();
        $reserve->total = $request->total;
        $reserve->check_in = now();
        $reserve->hotel_id = $hotel_id;

        $room->reserves()->save($reserve);

        return response()->json([
            'mensagem' => 'Reserva criada com sucesso.'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
