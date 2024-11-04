<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return response()->json([
            'dados' => $coupons
        ], 200);
    }

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
            'mensagem' => 'coupom criado com sucesso.'
        ],201);
    }

    public function show(string $id)
    {
        $coupon = Coupon::find($id);

        if(!$coupon){
            return response()->json([
                'mensagem' => 'coupon não encontrado.'
            ], 404);
        }

        return response()->json([
            'dados' => $coupon
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $coupon = Coupon::find($id);

        if(!$coupon){
            return response()->json([
                'mensagem' => 'coupon nao encontrado.'
            ], 404);
        }

        $coupon->code = $request->code;
        $coupon->discount_value = $request->discount_value;
        $coupon->expiration_date = $request->expiration_date;
        $coupon->save();

        return response()->json([
            'mensagem' => 'coupon atualizado com sucesso.'
        ], 200);
    }

    public function destroy(string $id)
    {
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'mensagem' => 'coupon nao encontrado'
            ], 404);
        }

        $coupon->delete();
        return response()->json([
            'mensagem' => 'coupon removido com sucesso.'
        ], 200);
    }

    public function couponOff($id){
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'mensagem' => 'coupon nao encontrado.'
            ], 404);
        }

        $coupon->status = false;
        $coupon->save();

        return response()->json([
            'mensagem' => 'coupon desativado.',
        ], 404);
    }

    public function couponOn($id){
        $coupon = Coupon::find($id);

        if (!$coupon) {
            return response()->json([
                'mensagem' => 'coupon nao encontrado.'
            ], 404);
        }

        $coupon->status = true;
        $coupon->save();

        return response()->json([
            'mensagem' => 'coupon ativado.',
        ], 200);
    }
}
