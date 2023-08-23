<?php

namespace App\Http\Controllers\affiliate\backend;

use App\Http\Controllers\Controller;
use App\Models\AffiliatePaidHistory;
use App\Models\AffiliatePaymentsAccount;
use App\Models\Settings;
use App\Notifications\AffiliatePaymentCancellation;
use App\Notifications\AffiliatePaymentConfirmation;
use App\User;
use App\Models\AffiliateAccount;
use App\Notifications\AffiliateApprovalToUser;
use App\Notifications\AffiliateBlockUser;
use App\Notifications\AffiliateUnblockUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Pagination\Paginator;
use Notification;

class AffiliateController extends Controller
{

    //redirecting to affiliate index page in admin
    public function index(){
        $activeUsers = AffiliateAccount::where('is_approved',1)->where('is_blocked', 0)->paginate(10);
        $blockedUsers = AffiliateAccount::where('is_approved',1)->where('is_blocked', 1)->paginate(10);
        return view('backend.affiliate.index', compact('activeUsers','blockedUsers'));
    }


    //redirecting to affiliate requests page in admin
    public function requestedUsers(){
        $users = AffiliateAccount::where('is_approved',0)->where('is_blocked', 0)->paginate(15);
        return view('backend.affiliate.request',compact('users'));
    }


    //redirecting to affiliate settings page in admin
    public function settings(){
        return view('backend.affiliate.settings');
    }


    //redirecting to affiliate payment page in admin
    public function affiliatePayments(){
        $requests = AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled', 0)->orderBy('updated_at','desc')->paginate(10);
        $paid = AffiliatePaidHistory::where('is_paid',1)->where('is_cancelled', 0)->orderBy('updated_at','desc')->paginate(10);
        $cancelled = AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled', 1)->orderBy('updated_at','desc')->paginate(10);
        return view('backend.affiliate.affiliatePayments', compact('requests','paid','cancelled'));
    }


    //storing affiliate settings
    public function storeSettings(Request $request){

        if ($request->has('affiliate_commission')) {
            $affiliateSettings = Settings::where('name','affiliate_commission')->first();
            $affiliateSettings->value = $request->affiliate_commission;
            $affiliateSettings->save();
        }
        if ($request->has('affiliate_min_withdrawal')) {
            $affiliateSettings = Settings::where('name', 'affiliate_min_withdrawal')->first();
            $affiliateSettings->value = $request->affiliate_min_withdrawal;
            $affiliateSettings->save();
        }
        if ($request->has('affiliate_cookie_limit')) {
            $affiliateSettings = Settings::where('name', 'affiliate_cookie_limit')->first();
            $affiliateSettings->value = $request->affiliate_cookie_limit;
            $affiliateSettings->save();
        }

        if ($request->has('affiliate_payment')) {
            $affiliateSettings = Settings::where('name', 'affiliate_payment')->first();
            $temp = implode(',', $request->affiliate_payment);
            $affiliateSettings->value = $temp;
            $affiliateSettings->save();
        }else{
            $affiliateSettings = Settings::where('name', 'affiliate_payment')->first();
            $affiliateSettings->value = null;
            $affiliateSettings->save();
        }

        Alert::toast(translate('Affiliate settings has been updated'),'success');
        return back();
    }



    //approving affiliate registration request
    public function approveRequest($id)
    {
        $affUser = AffiliateAccount::findOrFail($id);
        if ($affUser->affiliation_code == NULL){
            $affUser->affiliation_code = date('Y') . $affUser->user_id . random_int(10, 100);
        }
        $affUser->is_approved = true;
        $affUser->is_blocked = false;

        //creating payment account for user
        $account = new AffiliatePaymentsAccount;
        $account->user_id = $affUser->user_id;
        $account->save();


        try {
            $user = User::where('id', $affUser->user_id)->first();
            Notification::send($user, new AffiliateApprovalToUser());
        }catch (\Exception $e){}

        $affUser->save();
        Alert::toast(translate('Affiliate account has been approved'),'success');
        return back();
    }


    //blocking-unblocking affiliate account
    public function blockUnblockAffiliateAcc($id)
    {
        $affUser = AffiliateAccount::findOrFail($id);

        if($affUser->is_blocked == false) {
            //account blocking here
            if ($affUser->affiliation_code == NULL) {
                $affUser->affiliation_code = date('Y') . $affUser->user_id . random_int(10, 100);
            }
            $affUser->is_approved = true;
            $affUser->is_blocked = true;

            //creating payment account for user
            $account = AffiliatePaymentsAccount::where('user_id',$affUser->user_id)->first();
            if(is_null($account)){
                $account = new AffiliatePaymentsAccount;
                $account->user_id = $affUser->user_id;
                $account->save();
            }

            try {
                $user = User::where('id', $affUser->user_id)->first();
                Notification::send($user, new AffiliateBlockUser());
            } catch (\Exception $e) {
            }
            $affUser->save();
            Alert::toast(translate('Affiliate account has been blocked'), 'success');
        }else{
            //account unblocking here
            if ($affUser->affiliation_code == NULL) {
                $affUser->affiliation_code = date('Y') . $affUser->user_id . random_int(10, 100);
            }
            $affUser->is_approved = true;
            $affUser->is_blocked = false;
            try {
                $user = User::where('id', $affUser->user_id)->first();
                Notification::send($user, new AffiliateUnblockUser());
            } catch (\Exception $e) {
            }
            $affUser->save();
            Alert::toast(translate('Affiliate account has been unblocked'), 'success');
        }
        return back();
    }


    //approving a payment
    public function withdrawalDetails($id){
        $req = AffiliatePaidHistory::findOrFail($id);

        if($req->payment_account == "Bank"){
            return view('backend.affiliate.payments.bank',compact('req'));

        }elseif($req->payment_account == "PayPal"){
            return view('backend.affiliate.payments.paypal',compact('req'));

        }elseif($req->payment_account == "Stripe"){
            return view('backend.affiliate.payments.stripe',compact('req'));

        }elseif($req->payment_account == "PayTm"){
            return view('backend.affiliate.payments.paytm',compact('req'));

        }elseif($req->payment_account == "Bkash"){
            return view('backend.affiliate.payments.bkash',compact('req'));

        }elseif($req->payment_account == "Nagad"){
            return view('backend.affiliate.payments.nagad',compact('req'));

        }else{
            return view('backend.affiliate.payments.rocket',compact('req'));
        }
    }

    //approving a payment
    public function approveWithdrawAffiliatedMoney($id){
        $history = AffiliatePaidHistory::findOrFail($id);
        if($history->is_cancelled = false){
            $history->is_paid = true;
            $history->confirmed_by = Auth::id();
            $history->paid_date = Carbon::now();
        }else{
            $history->is_cancelled = false;
            $history->is_paid = true;
            $history->confirmed_by = Auth::id();
            $history->paid_date = Carbon::now();

            //reducing to users balance because while cancelling it was added to user balance
            $user = AffiliateAccount::where('user_id', $history->user_id)->first();
            $user->balance = ((int)$user->balance - $history->amount);
            $user->save();

        }

        try {
            $user = User::where('id', $history->user_id)->first();
            Notification::send($user, new AffiliatePaymentConfirmation());
        }catch (\Exception $e){}

        $history->save();
        Alert::toast(translate('Affiliate payment has been successful'), 'success');
        return redirect()->route('admins.affiliate.affiliatePayments');
    }

    //cancelling a payment
    public function cancelWithdrawAffiliatedMoney($id){
        $history = AffiliatePaidHistory::findOrFail($id);
        $history->is_paid = false;
        $history->is_cancelled = true;
        $history->confirmed_by = Auth::id();
        $history->paid_date = null;

        //adding to users balance
        $user = AffiliateAccount::where('user_id', $history->user_id)->first();
        $user->balance = ((int)$user->balance + $history->amount);

        try {
            $userMail = User::where('id', $history->user_id)->first();
            Notification::send($userMail, new AffiliatePaymentCancellation());
        }catch (\Exception $e){}

        $history->save();
        $user->save();

        Alert::toast(translate('Payment has been cancelled'), 'success');
        return redirect()->route('admins.affiliate.affiliatePayments');
    }

    //deleting affiliate registration request
    public function delete($id)
    {
        $affUser = AffiliateAccount::findOrFail($id);
        if($affUser->is_approved == false){
            $affUser->delete();
            Alert::toast(translate('Affiliate account has been deleted'),'success');
        }
        else{
            Alert::toast(translate('You can not delete an approved affiliate user, block instead.'),'error');
        }
        return back();
    }


    //Search in active affiliate account
    public function searchActive(Request $request)
    {
        $search = $request->searchActive;
        $users = User::where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->get();
        $allActiveUsers  = collect();
        $activeAffiliatedUsers = AffiliateAccount::where('is_approved',1)->where('is_blocked', 0)->get();
        foreach ($users as $user){
            foreach ($activeAffiliatedUsers as $activeUser){
                if($activeUser->user_id == $user->id){
                    $allActiveUsers->push($activeUser);
                }
            }
        }
        $activeUsers = new Paginator($allActiveUsers, 10);
        $blockedUsers = AffiliateAccount::where('is_approved',1)->where('is_blocked', 1)->paginate(10);
        return view('backend.affiliate.index', compact('activeUsers','blockedUsers'));
    }

    //Search in blocked affiliate account
    public function searchBlocked(Request $request)
    {
        $search = $request->searchBlocked;
        $users = User::where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%')->get();
        $allBlockedUsers  = collect();
        $blockedAffiliatedUsers = AffiliateAccount::where('is_approved',1)->where('is_blocked', 1)->get();
        foreach ($users as $user){
            foreach ($blockedAffiliatedUsers as $blockedUser){
                if($blockedUser->user_id == $user->id){
                    $allBlockedUsers->push($blockedUser);
                }
            }
        }
        $blockedUsers = new Paginator($allBlockedUsers, 10);
        $activeUsers = AffiliateAccount::where('is_approved',1)->where('is_blocked', 0)->paginate(10);
        return view('backend.affiliate.index', compact('activeUsers','blockedUsers'));
    }

    //Search in new affiliate account requests
    public function searchRequests(Request $request)
    {
        $search = $request->searchRequests;
        $users = User::where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('tel_number', 'like', '%' . $search . '%')
                ->get();

        $allUsers  = collect();
        $affiliatedUsers = AffiliateAccount::where('is_approved',0)->where('is_blocked', 0)->get();
        foreach ($users as $user){
            foreach ($affiliatedUsers as $affiliatedUser){
                if($affiliatedUser->user_id == $user->id){
                    $allUsers->push($affiliatedUser);
                }
            }
        }
        $users = new Paginator($allUsers, 10);
        return view('backend.affiliate.request',compact('users'));
    }


    //Search in request payments
    public function searchReqPayments(Request $request)
    {
        $search = $request->searchReqPayments;
        $users = User::where('name', 'like', '%' . $search . '%')->get();

        $allRequests  = collect();
        $affiliateReqPayments = AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled', 0)->orderBy('updated_at','desc')->get();
        foreach ($users as $user){
            foreach ($affiliateReqPayments as $affiliateReqPayment){
                if($affiliateReqPayment->user_id == $user->id){
                    $allRequests->push($affiliateReqPayment);
                }
            }
        }
        $requests = new Paginator($allRequests, 10);
        $paid = AffiliatePaidHistory::where('is_paid',1)->where('is_cancelled', 0)->orderBy('updated_at','desc')->paginate(10);
        $cancelled = AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled', 1)->orderBy('updated_at','desc')->paginate(10);
        return view('backend.affiliate.affiliatePayments', compact('requests','paid','cancelled'));
    }

    //Search in paid payments
    public function searchPaidPayments(Request $request)
    {
        $search = $request->searchPaidPayments;
        $users = User::where('name', 'like', '%' . $search . '%')->get();

        $allPaid  = collect();
        $affiliatePaidPayments = AffiliatePaidHistory::where('is_paid',1)->where('is_cancelled', 0)->orderBy('updated_at','desc')->get();
        foreach ($users as $user){
            foreach ($affiliatePaidPayments as $affiliatePaidPayment){
                if($affiliatePaidPayment->user_id == $user->id){
                    $allPaid->push($affiliatePaidPayment);
                }
            }
        }

        $paid = new Paginator($allPaid, 10);
        $requests = AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled', 0)->orderBy('updated_at','desc')->paginate(10);
        $cancelled = AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled', 1)->orderBy('updated_at','desc')->paginate(10);
        return view('backend.affiliate.affiliatePayments', compact('requests','paid','cancelled'));
    }

    //Search in cancelled payments
    public function searchCancelledPayments(Request $request)
    {
        $search = $request->searchCancelledPayments;
        $users = User::where('name', 'like', '%' . $search . '%')->get();

        $allCancelled  = collect();
        $affiliateCancelledPayments = AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled', 1)->orderBy('updated_at','desc')->get();
        foreach ($users as $user){
            foreach ($affiliateCancelledPayments as $affiliateCancelledPayment){
                if($affiliateCancelledPayment->user_id == $user->id){
                    $allCancelled->push($affiliateCancelledPayment);
                }
            }
        }
        $cancelled = new Paginator($allCancelled, 10);
        $requests = AffiliatePaidHistory::where('is_paid',0)->where('is_cancelled', 0)->orderBy('updated_at','desc')->paginate(10);
        $paid = AffiliatePaidHistory::where('is_paid',1)->where('is_cancelled', 0)->orderBy('updated_at','desc')->paginate(10);
        return view('backend.affiliate.affiliatePayments', compact('requests','paid','cancelled'));
    }
}
