<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\SellerAccount;
use App\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{

    /*payment request list*/
    public function index(Request $request)
    {
        if ($request->has('id')) {
            $payments = Payment::where('user_id', $request->id)->latest()->paginate(10);
        } else {
            $payments = Payment::latest()->paginate(paginate());
        }
        $seller = Vendor::latest()->get();
        return view('backend.payment.payment_index', compact('payments', 'seller'));
    }

    /*get the account details*/
    public function accountDetails($id, $userId, $method, $payId)
    {
        $account = SellerAccount::where('id', $id)->where('user_id', $userId)->first();
        $payment = Payment::where('id', $payId)->first();
        return view('backend.payment.payment_details', compact('method', 'account', 'payment'));
    }

    // If payment is confirm, then status is change
    public function status($id)
    {
        $payment = Payment::where('id', $id)->first();
        $payment->status = 'Confirm';
        $payment->status_change_date = Carbon::now();

        //change the instructor balance'
        $ins = Vendor::where('user_id', $payment->user_id)->first();

        //payment
        $payment->current_balance = $ins->balance;
        $ins->balance -= $payment->amount;//update the balance

        $payment->save();
        $ins->save();
        Alert::success(translate('Done'), translate('Payment status is updated'));
        return back();
    }

    //END
}
