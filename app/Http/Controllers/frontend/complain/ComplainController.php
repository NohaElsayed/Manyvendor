<?php

namespace App\Http\Controllers\frontend\complain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Complain;
use Alert;
use Auth;

class ComplainController extends Controller
{

    /**
     * COMPLAIN MODAL
     */
    public function index($code)
    {
        return view('frontend.complain.index',compact('code'));
    }

    /**
     * COMPLAIN REVIEW
     */
    public function review($code)
    {
        $complain_review = Complain::where('booking_code', $code)->first();
        return view('frontend.complain.review',compact('complain_review'));
    }

    /**
     * COMPLAIN STORE
     */
    public function store(Request $request)
    {
        $complain = new Complain();
        $complain->booking_code = $request->booking_code;
        $complain->desc = $request->desc;

        $xyz = collect();

        if ($request->hasFile('complain_photos')) {
            foreach($request->complain_photos as $photo){
                $upload = fileUpload($photo, 'complains');
                $xyz->push($upload);
            }
            $complain->complain_photos = $xyz;
        }

        $complain->status = 'Untouched';

        $complain->save();

        Alert::toast('Complain taken successfully', 'success')
                ->autoClose(5000)
                ->position('top-end');

        return back();
    }

}
