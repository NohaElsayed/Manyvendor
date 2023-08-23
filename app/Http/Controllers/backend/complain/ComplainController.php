<?php

namespace App\Http\Controllers\backend\complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complain;
use App\User;
use Auth;
use Alert;
use Carbon\Carbon;

class ComplainController extends Controller
{
    /*Complain index all show*/
    public function index()
    {
        $complains = Complain::latest()->with('orderproduct')->paginate(paginate());
        $users = User::where('user_type', 'Admin')->get();
        return view('backend.complain.index', compact('complains', 'users'));
    }

    /*complain show*/
    public function solved($id)
    {
        $complain = Complain::findOrFail($id);
        $complain->status = 'Solved';
        $complain->user_id = Auth::user()->id;
        $complain->save();

        Alert::toast('Complain Solved', 'success')
            ->autoClose(1000)
            ->position('top-end');

        return back();
    }

    /*complain not solved*/
    public function notsolved($id)
    {
        $complain = Complain::findOrFail($id);
        $complain->status = 'Not Solved';
        $complain->user_id = Auth::user()->id;
        $complain->save();

        Alert::toast('Complain Not Solved', 'success')
            ->autoClose(1000)
            ->position('top-end');

        return back();
    }


    /*filter form complain*/
    public function filter($type)
    {
        $getComplains = Complain::where('status', $type)->get();
        return view('backend.complain.filter', compact('getComplains'));
    }

    /*find complain*/
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

        } else {
            $getDatas = Complain::where($condition)->get();
        }

        return view('backend.complain.search_result', compact('getDatas'));

    }


}
