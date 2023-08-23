<?php

namespace App\Http\Controllers\ecommerce;

use App\Http\Controllers\Controller;
use App\Models\EcomOrderProduct;
use Illuminate\Http\Request;
use Alert;

class ReviewController extends Controller
{

//   review index
    public function index($code)
    {
        $order = EcomOrderProduct::where('booking_code', $code)->first();
        return view('frontend.review.index',compact('code','order'));
    }

   /*review store*/
    public function store(Request $request, $code)
    {
        $review = EcomOrderProduct::where('booking_code',$code)->first();
        $review->review=$request->desc;
        $review->review_star=$request->rating;

        $review->save();

        Alert::toast(translate('Review has been submitted successfully.'), 'success')
            ->autoClose(5000)
            ->position('top-end');

        return back();
    }
}
