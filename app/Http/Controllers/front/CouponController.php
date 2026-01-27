<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Services\front\CouponService;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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

    public function apply(Request $request)
    {
        $request->validate(['coupon_code' => 'required|string']);
        $resp = $this->couponService->applyCoupon($request->input('coupon_code'));
        return response()->json($resp, $resp['status'] ? 200 : 422);
    }

    public function remove(Request $request)
    {
        $resp = $this->couponService->removeCoupon();
        return response()->json($resp, $resp['status'] ? 200 : 422);
    }
}
