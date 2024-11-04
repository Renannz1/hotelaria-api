<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Coupons",
 *     description="Endpoints: Coupons"
 * )
 */
class CouponController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/coupons",
     *     tags={"Coupons"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna uma lista de cupons"
     *     )
     * )
     */
    public function index()
    {
        $coupons = Coupon::all();
        return response()->json([
            'dados' => $coupons
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/coupons",
     *     tags={"Coupons"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="code",
     *                 type="string",
     *                 description="Código do cupom"
     *             ),
     *             @OA\Property(
     *                 property="discount_value",
     *                 type="number",
     *                 description="Valor do desconto"
     *             ),
     *             @OA\Property(
     *                 property="expiration_date",
     *                 type="string",
     *                 format="date",
     *                 description="Data de expiração do cupom"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Cupom criado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dados inválidos"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount_value' => 'required|numeric',
            'expiration_date' => 'nullable|date|after:today'
        ]);

        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->discount_value = $request->discount_value;
        $coupon->expiration_date = $request->expiration_date;
        $coupon->save();

        return response()->json([
            'mensagem' => 'Cupom criado com sucesso.'
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/coupons/{id}",
     *     tags={"Coupons"},
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
     *         description="Retorna os dados de um cupom específico"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cupom não encontrado"
     *     )
     * )
     */
    public function show(string $id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'mensagem' => 'Cupom não encontrado.'
            ], 404);
        }

        return response()->json([
            'dados' => $coupon
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/coupons/{id}",
     *     tags={"Coupons"},
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
     *                 property="code",
     *                 type="string",
     *                 description="Código do cupom"
     *             ),
     *             @OA\Property(
     *                 property="discount_value",
     *                 type="number",
     *                 description="Valor do desconto"
     *             ),
     *             @OA\Property(
     *                 property="expiration_date",
     *                 type="string",
     *                 format="date",
     *                 description="Data de expiração do cupom"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Cupom atualizado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cupom não encontrado"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Dados inválidos"
     *     )
     * )
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons,code',
            'discount_value' => 'required|numeric',
            'expiration_date' => 'nullable|date|after:today'
        ]);

        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'mensagem' => 'Cupom não encontrado.'
            ], 404);
        }

        $coupon->code = $request->code;
        $coupon->discount_value = $request->discount_value;
        $coupon->expiration_date = $request->expiration_date;
        $coupon->save();

        return response()->json([
            'mensagem' => 'Cupom atualizado com sucesso.'
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/coupons/{id}",
     *     tags={"Coupons"},
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
     *         description="Cupom removido com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cupom não encontrado"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'mensagem' => 'Cupom não encontrado.'
            ], 404);
        }

        $coupon->delete();
        return response()->json([
            'mensagem' => 'Cupom removido com sucesso.'
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/coupons/{id}/off",
     *     tags={"Coupons"},
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
     *         description="Cupom desativado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cupom não encontrado"
     *     )
     * )
     */
    public function couponOff($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'mensagem' => 'Cupom não encontrado.'
            ], 404);
        }

        $coupon->status = false;
        $coupon->save();

        return response()->json([
            'mensagem' => 'Cupom desativado.'
        ], 200);
    }

    /**
     * @OA\Put(
     *     path="/api/coupons/{id}/on",
     *     tags={"Coupons"},
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
     *         description="Cupom ativado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cupom não encontrado"
     *     )
     * )
     */
    public function couponOn($id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'mensagem' => 'Cupom não encontrado.'
            ], 404);
        }

        $coupon->status = true;
        $coupon->save();

        return response()->json([
            'mensagem' => 'Cupom ativado.'
        ], 200);
    }
}
