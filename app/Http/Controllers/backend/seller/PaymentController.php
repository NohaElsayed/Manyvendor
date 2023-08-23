<?php

namespace App\Http\Controllers\backend\seller;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\SellerAccount;
use App\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;

class PaymentController extends Controller
{
    /*All Payment List*/
    public function index(Request $request)
    {
        $payments = Payment::where('user_id', Auth::id())
                            ->latest()
                            ->paginate(paginate());

        

        return view('backend.sellers.payment.payment_index', compact('payments'));
    }

    /* payment request form*/
    public function create()
    {
        $vendor = Vendor::where('user_id', Auth::id())->first();

        $check_account = SellerAccount::where('user_id', Auth::id())
                                       ->first();

        return view('backend.sellers.payment.create', compact('vendor','check_account'));
    }

    /*Payment request*/
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required',
        ],
            [
                'amount.required' => translate('Amount is required'),
            ]);

        if ($request->amount < 10) {
            Alert::warning(translate('Alert'), translate('You minimum Withdrawal 10 Money'));
            return back();
        }

        $account = SellerAccount::where('user_id', Auth::id())->first();
        if ($account == null) {
            Alert::warning(translate('Alert'), translate('Please Insert the withdrawal method'));
            return back();
        }
        $ins = Vendor::where('user_id', Auth::id())->first();
        if ($ins->balance < $request->amount) {
            Alert::warning(translate('Alert'), translate('Please insert the valid withdrawal amount'));
            return back();
        }

        $payment = new Payment();
        $payment->amount = $request->amount;
        $payment->process = $request->process;
        $payment->description = $request->description;
        $payment->status = $request->status;
        $payment->status_change_date = Carbon::now();
        $payment->user_id = Auth::id();
        $payment->account_id = $account->id;
        $payment->saveOrFail();

        Alert::success(translate('Done'), translate('Payment request sent successfully'));
        return back();
    }

    public function destroy($id)
    {
        Payment::where('id', $id)->delete();
        Alert::success(translate('Done'), translate('Payment request deleted successfully'));
        return redirect()->route('payments.index');
    }


    /*instructor payment account*/
    public function accountSetup()
    {
        $account = SellerAccount::where('user_id', Auth::id())->first();
        return view('backend.sellers.payment.account_create', compact('account'));
    }

    /*update the account details*/
    public function accountUpdate(Request $request)
    {
        if ($request->has('id')) {
            $account = SellerAccount::where('id', $request->id)->where('user_id', Auth::id())->first();
            $account->bank_name = $request->bank_name;
            $account->account_name = $request->account_name;
            $account->account_number = $request->account_number;
            $account->routing_number = $request->routing_number;
            $account->paypal_acc_name = $request->paypal_acc_name;
            $account->paypal_acc_email = $request->paypal_acc_email;
            $account->stripe_acc_name = $request->stripe_acc_name;
            $account->stripe_acc_email = $request->stripe_acc_email;
            $account->stripe_card_holder_name = $request->stripe_card_holder_name;
            $account->stripe_card_number = $request->stripe_card_number;
            $account->save();
        } else {
            $account = new SellerAccount();
            $account->bank_name = $request->bank_name;
            $account->account_name = $request->account_name;
            $account->account_number = $request->account_number;
            $account->routing_number = $request->routing_number;
            $account->paypal_acc_name = $request->paypal_acc_name;
            $account->paypal_acc_email = $request->paypal_acc_email;
            $account->stripe_acc_name = $request->stripe_acc_name;
            $account->stripe_acc_email = $request->stripe_acc_email;
            $account->stripe_card_holder_name = $request->stripe_card_holder_name;
            $account->stripe_card_number = $request->stripe_card_number;
            $account->user_id = Auth::id();
            $account->save();
        }

        Alert::success(translate('Done'), translate('Payment account setup done successfully'));
        return back();
    }

    /*get the account details*/
    public function accountDetails($id, $userId, $method, $payId)
    {
        $account = SellerAccount::where('id', $id)->where('user_id', $userId)->first();
        $payment = Payment::where('id', $payId)->first();
        return view('module.payment.details', compact('method', 'account', 'payment'));
    }

}
