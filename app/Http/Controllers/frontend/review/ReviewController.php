<?php

namespace App\Http\Controllers\frontend\review;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderProduct;
use Alert;

class ReviewController extends Controller
{
   /*review index*/
    public function index($code)
    {
        $order = OrderProduct::where('booking_code', $code)->first();
        return view('frontend.review.index',compact('code','order'));
    }

    /*review store*/
    public function store(Request $request, $code)
    {
        $review = OrderProduct::where('booking_code',$code)->first();
        $review->review=$request->desc;
        $review->review_star=$request->rating;

        $review->save();

        Alert::toast('Review has been submitted successfully.', 'success')
                ->autoClose(5000)
                ->position('top-end');

        return back();
    }


}
