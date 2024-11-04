<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Hotel;
use App\Models\Reserve;
use App\Models\Room;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Reserves",
 *     description="Endpoints: Reserves"
 * )
 */
class ReserveController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/reserves",
     *     tags={"Reserves"},
     *     @OA\Response(
     *         response=200,
     *         description="Retorna uma lista de reservas"
     *     )
     * )
     */
    public function index()
    {
        $reserves = Reserve::all();

        return response()->json([
            'dados' => $reserves,
        ], 200);
    }

    /**
     * @OA\Post(
     *     path="/api/reserves",
     *     tags={"Reserves"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="room_id",
     *                 type="integer",
     *                 description="ID do quarto"
     *             ),
     *             @OA\Property(
     *                 property="total",
     *                 type="number",
     *                 description="Total da reserva"
     *             ),
     *             @OA\Property(
     *                 property="coupon_code",
     *                 type="string",
     *                 description="Código do cupom"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Reserva criada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Quarto não encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Falha ao criar reserva"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'total' => 'required|numeric',
            'coupon_code' => 'nullable|string|exists:coupons,code'
        ]);

        $room = Room::find($request->room_id);

        if (!$room) {
            return response()->json([
                'mensagem' => 'Quarto não encontrado.'
            ], 404);
        }

        $hotel_id = $room->hotel_id;

        $reserve = new Reserve();
        $reserve->total = $request->total;
        $reserve->check_in = now();
        $reserve->hotel_id = $hotel_id;

        $room->reserves()->save($reserve);

        $msgCoupon = 'Cupom não aplicado.';

        if ($request->filled('coupon_code')) {
            $this->applyCoupon($reserve, $request->coupon_code);
            $msgCoupon = "Cupom {$request->coupon_code} aplicado.";
        }

        return response()->json([
            'mensagem' => 'Reserva criada com sucesso.',
            'cupom' => $msgCoupon
        ], 201);
    }

    private function applyCoupon(Reserve $reserve, $couponCode)
    {
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon || !$coupon->status) {
            return response()->json([
                'mensagem' => 'Cupom inválido ou não encontrado.'
            ], 404);
        }

        if ($coupon->expiration_date < now()) {
            return response()->json([
                'mensagem' => 'Cupom expirado'
            ], 400);
        }

        $totalSemDesconto = $reserve->total;
        $discountTotal = max(0, $reserve->total - $coupon->discount_value);

        $reserve->coupon_id = $coupon->id;
        $reserve->total = $discountTotal;
        $reserve->save();
    }
}
