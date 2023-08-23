<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentsController extends Controller
{
    /*payment index*/
    public function index()
    {
        return view('backend.common.setting.payment.payment-methods');
    }

    /*payment history store*/
    public function store(Request $request)
    {
        foreach ($request->types as $key => $type) {
            overWriteEnvFile($type, $request[$type]);
        }
        Alert::success('Done', translate('Payment methods has been updated.'));
        return back();
    }

    /*logo store*/
    public function logoStore(Request $request)
    {
        if ($request->hasFile('payment_logo')) {
            if ($request->has('payment_logo')) {
                $system = Settings::where('name', 'payment_logo')->first();
                $system->value = fileUpload($request->payment_logo, 'logo');
                $system->save();
            }
        }
        Alert::success('Done', translate('Payment\'s logo has been updated.'));
        return back();
    }
}
