<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\AdminCommission;
use Illuminate\Http\Request;

class EarningController extends Controller
{
    //

    /*admin earning history*/
    public function index(Request $request){
        if ($request->has('search')){
            $earning = AdminCommission::latest()->where('booking_code',$request->search)->paginate(paginate());
        }else{
            $earning = AdminCommission::latest()->paginate(paginate());
        }

        $total_earning = AdminCommission::get()->sum('commission');
        return view('backend.settings.earning',compact('earning','total_earning'));
    }

}
