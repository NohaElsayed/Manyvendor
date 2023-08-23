<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\VerifyUser;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /*check here*/

    protected function authenticated(Request $request, $user)
    {

        $id = $user->id;
        if ($user->banned == true) {
            auth()->logout();
            return back()->with('warning', translate('You are banned By The Admin, Please Contact with admin'));
        }
        if (!vendorActive()){
            if ($user->user_type == "Vendor"){
                auth()->logout();
                return back()->with('warning', translate('You Account is not accessible'));
            }
        }
        if (getSystemSetting('verification') == "on" && !$user->email_verified_at){
            auth()->logout();
            return view('auth.verify',compact('id'));
        }

        /*store login time*/
        $user->login_time = Carbon::now();
        $user->save();



    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('Sorry, your password or email was incorrect.')],
        ]);
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
