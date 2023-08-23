<?php

namespace App\Http\Controllers\ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Complain;
use App\User;
use Alert;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ComplainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $complains = Complain::latest()->with('ecom_order_product')->paginate(paginate());
        $users  = User::where('user_type', 'Admin')->get();
        return view('backend.ecommerce.complain_index', compact('complains','users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function solved($id)
    {
        $complain = Complain::findOrFail($id);
        $complain->status=   'Solved';
        $complain->user_id=   Auth::user()->id;
        $complain->save();

        Alert::toast('Complain Solved', 'success')
            ->autoClose(1000)
            ->position('top-end');

        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function notsolved($id)
    {
        $complain = Complain::findOrFail($id);
        $complain->status=   'Not Solved';
        $complain->user_id=   Auth::user()->id;
        $complain->save();

        Alert::toast('Complain Not Solved', 'success')
            ->autoClose(1000)
            ->position('top-end');

        return back();
    }

    /**
     * FILTER COMPLAIN
     */

    public function filter($type)
    {
        $getComplains = Complain::where('status', $type)->get();
        return view('backend.ecommerce.complain_filter',compact('getComplains'));
    }

    /**
     * FIND COMPLAIN
     */

    public function find_complain(Request $request)
    {
        $getDatas = null;
        $condition = array();

        if (!is_null($request->booking_code)) {
            $condition = array_merge($condition, ['booking_code' => $request->booking_code]);
        }

        if (!is_null($request->end_date)) {
            $start = null;
            $end = Carbon::parse($request->end_date)
                ->endOfDay()
                ->toDateTimeString();
            if ($request->has('start_date')) {
                $start = Carbon::parse($request->start_date)
                    ->startOfDay()
                    ->toDateTimeString();
            } else {
                $start = Carbon::yesterday()->startOfDay()->toDateTimeString();
            }

            if (empty($condition)) {
                $getDatas = Complain::whereBetween('created_at', [$start, $end])->get();
            } else {
                $getDatas = Complain::where($condition)->whereBetween('created_at', [$start, $end])->get();
            }

        }else{
            $getDatas = Complain::where($condition)->get();
        }

        return view('backend.ecommerce.complain_search_index', compact('getDatas'));

    }
}
