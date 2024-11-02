<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelsController extends Controller
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
