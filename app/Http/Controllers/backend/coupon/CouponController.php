<?php

namespace App\Http\Controllers\backend\coupon;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Alert;
use Carbon\Carbon;
use App\Models\Coupon;

class CouponController extends Controller
{
    //coupon index
    public function index()
    {
        $coupons = Coupon::latest()->get();
        return view('backend.coupon.index', compact('coupons'));
    }

    //store coupons
    public function store(Request $request)
    {
        $coupon = new Coupon();
        $coupon->code = $request->code;
        $coupon->rate = $request->rate;
        $coupon->start_day = Carbon::parse($request->start_day);
        $coupon->end_day = Carbon::parse($request->end_day);
        $coupon->min_value = $request->min_value;

        if ($request->is_published == 'on') {
            $coupon->is_published = true;
        } else {
            $coupon->is_published = false;
        }

        $coupon->save();
        Alert::success(translate('Done'), translate('Coupon Created Successfully'));
        return back();
    }

    //coupon edit
    public function edit($id)
    {
        $single_coupon = Coupon::findOrFail($id);
        return view('backend.coupon.edit', compact('single_coupon'));
    }

    // coupon_activation
    public function coupon_activation(Request $request)
    {
        $coupon_activation = Coupon::where('id', $request->id)->first();

        if ($coupon_activation->is_published == 0) {
            $coupon_activation->is_published = 1;
            $coupon_activation->save();
        } else {
            $coupon_activation->is_published = 0;
            $coupon_activation->save();
        }

        return response(['message' => 'Status changed'], 200);
    }

    //coupon update
    public function update(Request $request, $id)
    {
        $coupon_update = Coupon::findOrFail($id);
        $coupon_update->code = $request->code;
        $coupon_update->rate = $request->rate;
        $coupon_update->start_day = Carbon::parse($request->start_day);
        $coupon_update->end_day = Carbon::parse($request->end_day);
        $coupon_update->min_value = $request->min_value;

        if ($request->is_published == 'on') {
            $coupon_update->is_published = true;
        } else {
            $coupon_update->is_published = false;
        }

        $coupon_update->save();
        Alert::success(translate('Done'), translate('Coupon Updated Successfully'));
        return back();
    }

}
