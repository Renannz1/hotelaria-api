<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Rooms",
 *     description="Endpoints: Rooms"
 * )
 */
class RoomController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/rooms",
     *     tags={"Rooms"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna uma lista de quartos"
     *     )
     * )
     */
    public function index()
    {
        $rooms = Room::all();

        return response()->json([
            'dados' => $rooms,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/rooms",
     *     tags={"Rooms"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="hotel_id",
     *                 type="integer",
     *                 description="ID do hotel"
     *             ),
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Nome do quarto"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Quarto criado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Hotel não encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Falha ao criar quarto"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
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

    /**
     * @OA\Get(
     *     path="/api/rooms/{id}",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Retorna os dados de um quarto específico"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Quarto não encontrado"
     *     )
     * )
     */
    public function show(string $id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json([
                'mensagem' => 'Quarto não encontrado.',
            ], 400);
        }

        return response()->json([
            'dados' => $hotel
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/rooms/{id}",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Nome do quarto"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Quarto atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Quarto não encontrado"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $room = Room::find($id);

        if (!$room) {
            return response()->json([
                'mensagem' => 'Quarto não encontrado.'
            ], 400);
        }

        $room->name = $request->name;
        $room->save();

        return response()->json([
            'mensagem' => 'Quarto atualizado.'
        ]);
    }

    /**
     * @OA\Delete(
     *     path="/api/rooms/{id}",
     *     tags={"Rooms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Quarto deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Quarto não encontrado"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json([
                'mensagem' => 'Quarto não encontrado.'
            ], 400);
        }

        $room->delete();

        return response()->json([
            'mensagem' => 'Quarto deletado.'
        ], 200);
    }
}
