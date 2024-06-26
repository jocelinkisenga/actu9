<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Image;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $recentCoupons = Coupon::latest()->get();

        return view("pages.listCoupons",compact("recentCoupons"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pages.addCoupon");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {

        $coupon = Coupon::create([
            "type_id" => $request->type_id,
            "title" => $request->title,
            "description" => $request->description
        ]);

        foreach ($request->image as $key => $image) {
            $imgName = Carbon::now()->timestamp . $key . '_mns.' . $image->extension();
            $path = $image->storeAs('uploads',$imgName,'public');
            Image::create(['coupon_id'=>$coupon->id,'image_url'=>$imgName]);

        }
        return redirect()->route("dashboard");
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $coupons = Coupon::findOrFail($id);
        return view("pages.editCoupon",compact("coupons"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(int $id)
    {
        Coupon::destroy($id);

        return redirect()->back();
    }
}
