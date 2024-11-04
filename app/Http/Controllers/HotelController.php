<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Hotels",
 *     description="Endpoints: Hotels"
 * )
 */
class HotelController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/hotels",
     *     tags={"Hotels"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna uma lista de hotéis"
     *     )
     * )
     */
    public function index()
    {
        $hotels = Hotel::all();

        return response()->json([
            'dados' => $hotels,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/hotels",
     *     tags={"Hotels"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 description="Nome do hotel"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Hotel adicionado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Falha ao adicionar Hotel"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $hotel = new Hotel();
        $hotel->name = $request->name;

        if ($hotel->save()) {
            return response()->json([
                'mensagem' => 'Hotel adicionado com sucesso!',
            ], 201);
        } else {
            return response()->json([
                'mensagem' => 'Falha ao adicionar Hotel.'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/hotels/{id}",
     *     tags={"Hotels"},
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
     *         description="Retorna os dados de um hotel específico"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Hotel não encontrado"
     *     )
     * )
     */
    public function show(string $id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
            return response()->json([
                'mensagem' => 'Hotel não encontrado.',
            ], 400);
        }

        return response()->json([
            'dados' => $hotel,
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/hotels/{id}",
     *     tags={"Hotels"},
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
     *                 description="Nome do hotel"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hotel atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Hotel não encontrado"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $hotel = Hotel::find($id);

        if (!$hotel) {
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

    /**
     * @OA\Delete(
     *     path="/api/hotels/{id}",
     *     tags={"Hotels"},
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
     *         description="Hotel deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Hotel não encontrado"
     *     )
     * )
     */
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
            'mensagem' => 'Hotel deletado.'
        ], 200);
    }
}
