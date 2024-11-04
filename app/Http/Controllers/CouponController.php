<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {

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
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
