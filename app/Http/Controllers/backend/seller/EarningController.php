<?php

namespace App\Http\Controllers\backend\seller;

use App\Http\Controllers\Controller;
use App\Models\SellerEarning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EarningController extends Controller
{
    //earning history
    public function index(Request $request){
        if ($request->has('search')){
            $earning = SellerEarning::where('user_id',Auth::id())->latest()->where('booking_code',$request->search)->paginate(paginate());
        }else{
            $earning = SellerEarning::where('user_id',Auth::id())->latest()->paginate(paginate());
        }

        $total_earning = SellerEarning::where('user_id',Auth::id())->get()->sum('get_amount');
        return view('backend.sellers.earning',compact('earning','total_earning'));
    }
}
