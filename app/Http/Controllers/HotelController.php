<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();

        return response()->json([
            'dados' => $hotels,
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $hotel = New Hotel();
        $hotel->name = $request->name;

        if($hotel->save()){
            return response()->json([
                'mensagem' => 'Hotel adicionado com sucesso!',
            ], 201);
        } else {
            return response()->json([
                'mensagem' => 'Falha ao adicionar Hotel.'
            ], 500);
        }
    }

    public function show(string $id)
    {
        $hotel = Hotel::find($id);

        if(!$hotel){
            response()->json([
                'mensagem' => 'Hotel não encontrado.',
            ], 400);
        }

        return response()->json([
            'dados' => $hotel,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $hotel = Hotel::find($id);

        if(!$hotel){
            return response()->json([
                'mensagem' => 'Hotel não encontrado.',
            ], 400);
        }

        $request->validate([
            'name' => 'required|string'
        ]);

        $hotel->name = $request->name;
        $hotel->save();

        return response()->json([
            'dados' => $hotel,
        ], 200);
    }

    public function destroy(string $id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json([
                'mensagem' => 'Hotel não encontrado.'
            ], 400);
        }

        $hotel->delete();

        return response()->json([
            'mensagem' => 'Hotel deletado com sucesso.'
        ], 200);
    }
}
