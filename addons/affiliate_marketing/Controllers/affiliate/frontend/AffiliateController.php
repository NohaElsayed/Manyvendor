<?php

namespace App\Http\Controllers\affiliate\frontend;

use App\Http\Controllers\Controller;
use App\Models\AffiliateAccount;
use App\Models\AffiliatePaidHistory;
use App\Models\AffiliatePaymentsAccount;
use App\Models\AffiliateSellHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AffiliateController extends Controller
{
    //redirecting to affiliate registration view
    public function index(){
        return view('frontend.affiliate.registration');
    }

    //redirecting to affiliate product link generation view
    public function productLink(){
        return view('frontend.affiliate.productLink');
    }

    //redirecting to affiliate earning Histories view
    public function earningHistory(){
        $histories = AffiliateSellHistory::where('user_id', Auth::id())->where('is_pending', 0)->paginate(15);
        return view('frontend.affiliate.earningHistory', compact('histories'));
    }

    //redirecting to affiliate payment Histories view
    public function paymentHistory(){
        $pendingHistories = AffiliatePaidHistory::where('user_id', Auth::id())->where('is_paid',0)->where('is_cancelled',0)->paginate(15);
        $paidHistories = AffiliatePaidHistory::where('user_id', Auth::id())->where('is_paid',1)->where('is_cancelled',0)->paginate(15);
        $cancelledHistories = AffiliatePaidHistory::where('user_id', Auth::id())->where('is_paid',0)->where('is_cancelled',1)->paginate(15);
        return view('frontend.affiliate.paymentHistory', compact('paidHistories','pendingHistories', 'cancelledHistories'));
    }

    //redirecting to affiliate set Payment Accounts view
    public function setPaymentAccounts(){
        $account = AffiliatePaymentsAccount::where('user_id',Auth::user()->id)->first();
        return view('frontend.affiliate.setPaymentAccounts', compact('account'));
    }

    //redirecting to withdraw Affiliated Money view
    public function withdrawAffiliatedMoney(){
        return view('frontend.affiliate.withdrawAffiliatedMoney');
    }


    //storing affiliate account requests
    public function store(Request $request){
        $affAcc = new AffiliateAccount;
        $affAcc->user_id = $request->user_id;
        $affAcc->save();
        Alert::success(translate('Your affiliate registration request has been submitted to admin.'))->persistent($autoClose=false)->width('600px');
        return back();
    }


    //storing Payment Accounts
    public function storePaymentAccounts(Request $request){
        $existing_account = AffiliatePaymentsAccount::where('user_id',Auth::user()->id)->first();
        if(!is_null($existing_account)){
            //bank
            $existing_account->bank_name = $request->bank_name;
            $existing_account->account_name = $request->account_name;
            $existing_account->account_number = $request->account_number;
            $existing_account->routing_number = $request->routing_number;
            //paypal
            $existing_account->paypal_acc_name = $request->paypal_acc_name;
            $existing_account->paypal_acc_email = $request->paypal_acc_email;
            //stripe
            $existing_account->stripe_acc_name = $request->stripe_acc_name;
            $existing_account->stripe_acc_email = $request->stripe_acc_email;
            $existing_account->stripe_card_holder_name = $request->stripe_card_holder_name;
            $existing_account->stripe_card_number = $request->stripe_card_number;
            //payTm
            $existing_account->PayTm_number = $request->PayTm_number;
            //bKash
            $existing_account->bKash_number = $request->bKash_number;
            //nagad
            $existing_account->nagad_number = $request->nagad_number;
            //rocket
            $existing_account->rocket_number = $request->rocket_number;

            $existing_account->save();
        }else{
            $account = new AffiliatePaymentsAccount;
            //bank
            $account->user_id = Auth::user()->id;
            $account->bank_name = $request->bank_name;
            $account->account_name = $request->account_name;
            $account->account_number = $request->account_number;
            $account->routing_number = $request->routing_number;
            //paypal
            $account->paypal_acc_name = $request->paypal_acc_name;
            $account->paypal_acc_email = $request->paypal_acc_email;
            //stripe
            $account->stripe_acc_name = $request->stripe_acc_name;
            $account->stripe_acc_email = $request->stripe_acc_email;
            $account->stripe_card_holder_name = $request->stripe_card_holder_name;
            $account->stripe_card_number = $request->stripe_card_number; //payTm
            $account->PayTm_number = $request->PayTm_number;
            //bKash
            $account->bKash_number = $request->bKash_number;
            //nagad
            $account->nagad_number = $request->nagad_number;
            //rocket
            $account->rocket_number = $request->rocket_number;
            $account->save();
        }
        Alert::success(translate('Payment account has been updated'))->persistent($autoClose=false)->width('600px');
        return back();
    }


    //storing withdraw Affiliated Money request
    public function storeWithdrawAffiliatedMoney(Request $request)
    {
        $request->validate([
            'amount' => 'numeric',
        ]);

        $min_withdrawal = (int)getSystemSetting('affiliate_min_withdrawal');
        if($request->amount < $min_withdrawal){
            Alert::error(translate('You can not withdraw less than the minimum withdrawal amount.'))->persistent($autoClose=false)->width('600px');
            return back();
        }else{
            $user = AffiliateAccount::where('user_id', Auth::id())->first();
            if((int)$user->balance > $request->amount ){
                //reducing users balance
                $user->balance = ((int)$user->balance - $request->amount);

                //storing request
                $withdraw_req = new AffiliatePaidHistory;
                $withdraw_req->user_id = Auth::id();
                $withdraw_req->amount = $request->amount;
                $withdraw_req->payment_account = $request->payment_account;

                $withdraw_req->save();
                $user->save();

                Alert::success(translate('Your withdrawal request has been sent to admin.'))->persistent($autoClose=false)->width('600px');
                return back();
            }
            else{
                Alert::error(translate('Your current balance is less than minimum withdrawal amount.'))->persistent($autoClose=false)->width('600px');
                return back();
            }
        }
    }


    //delete affiliate withdraw request modal
    public function deleteRequestBlade($id){
        $req = AffiliatePaidHistory::findOrFail($id);
        return view('frontend.affiliate.deleteRequest', compact('req'));
    }


    //delete affiliate withdraw request
    public function deleteRequest(Request $request){
        $req = AffiliatePaidHistory::where('id', $request->id)->where('user_id', Auth::id())->first();
        if($req->is_paid != 1 && $req->is_cancelled != 1) {
            //adding to balance
            $user = AffiliateAccount::where('user_id', $req->user_id)->first();
            $user->balance = $user->balance + $req->amount;

            $user->save();
            $req->delete();

            Alert::success(translate('Your withdrawal request has been deleted'))->persistent($autoClose = false)->width('600px');
            return redirect()->route('customers.affiliate.paymentHistory');
        }else{
            Alert::error(translate('Something went wrong, please try again.'))->persistent($autoClose = false)->width('600px');
            return redirect()->route('customers.affiliate.paymentHistory');
        }
    }


    //earning History Filter
    public function earningHistoryFilter(Request $request){
        $histories = AffiliateSellHistory::whereBetween('created_at', [$request->earning_from, $request->earning_to])->where('is_pending',0)->paginate(15);
        return view('frontend.affiliate.earningHistory', compact('histories'));
    }


    //pending Payment History Filter
    public function pendingPaymentHistoryFilter(Request $request){
        $pendingHistories = AffiliatePaidHistory::where('user_id', Auth::id())
                            ->where('is_paid',0)
                            ->where('is_cancelled',0)
                            ->whereBetween('created_at', [$request->pending_from, $request->pending_to])->paginate(15);
        $paidHistories = AffiliatePaidHistory::where('user_id', Auth::id())->where('is_paid',1)->where('is_cancelled',0)->paginate(15);
        $cancelledHistories = AffiliatePaidHistory::where('user_id', Auth::id())->where('is_paid',0)->where('is_cancelled',1)->paginate(15);
        return view('frontend.affiliate.paymentHistory', compact('paidHistories','pendingHistories', 'cancelledHistories'));
    }


    //paid Payment History Filter
    public function paidPaymentHistoryFilter(Request $request){
        $paidHistories = AffiliatePaidHistory::where('user_id', Auth::id())
                        ->where('is_paid',1)
                        ->where('is_cancelled',0)
                        ->whereBetween('created_at', [$request->paid_from, $request->paid_to])->paginate(15);
        $pendingHistories = AffiliatePaidHistory::where('user_id', Auth::id())->where('is_paid',0)->where('is_cancelled',0)->paginate(15);
        $cancelledHistories = AffiliatePaidHistory::where('user_id', Auth::id())->where('is_paid',0)->where('is_cancelled',1)->paginate(15);
        return view('frontend.affiliate.paymentHistory', compact('paidHistories','pendingHistories', 'cancelledHistories'));
    }


    //cancelled Payment History Filter
    public function cancelledPaymentHistoryFilter(Request $request){
        $cancelledHistories = AffiliatePaidHistory::where('user_id', Auth::id())
                            ->where('is_paid',0)
                            ->where('is_cancelled',1)
                            ->whereBetween('created_at', [$request->cancelled_from, $request->cancelled_to])->paginate(15);
        $pendingHistories = AffiliatePaidHistory::where('user_id', Auth::id())->where('is_paid',0)->where('is_cancelled',0)->paginate(15);
        $paidHistories = AffiliatePaidHistory::where('user_id', Auth::id())->where('is_paid',1)->where('is_cancelled',0)->paginate(15);
        return view('frontend.affiliate.paymentHistory', compact('paidHistories','pendingHistories', 'cancelledHistories'));
    }
}
