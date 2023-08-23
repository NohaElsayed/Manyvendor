<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\frontend\customer\CustomersController;

use App\Notifications\VerifyNotifications;
use App\Providers\RouteServiceProvider;
use App\User;
use App\VerifyUser;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
        ],[
            'name.required'=>'Name is required',
            'email.required'=>'Email is required',
            'email.unique'  =>'An user exits with this email',
            'password.required'=>'Password is required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));


        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        $id = $user->id;
        if ($request->wantsJson()) {
            return new JsonResponse([], 201);
        } else {
            //send verification mail
            $verifyuser = VerifyUser::where('user_id', $id)->first();
            if ($verifyuser) {
                $verifyuser->user->notify(new VerifyNotifications($verifyuser->user));
            } else {
                $user = User::where('id',$id)->first();
                if ($user) {
                    //verify email
                    $verifyUser = VerifyUser::create([
                        'user_id' => $user->id,
                        'token' => sha1(time())
                    ]);
                    $verifyuser = VerifyUser::where('user_id',$id)->first();
                    $verifyuser->user->notify(new VerifyNotifications($verifyuser->user));
                }
            }
            return (getSystemSetting('verification') == "on" && !$user->email_verified_at)
                ? view('auth.verify', compact('id'))
                : redirect($this->redirectPath());
        }
    }

    protected function create(array $data)
    {

        //slug save
        $slug = Str::slug($data['name']);
        $person = User::where('slug', $slug)->get();
        if ($person->count() > 0) {
            $slug1 = $slug . ($person->count() + 1);
        } else {
            $slug1 = $slug;
        }

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->slug = $slug1;
        $user->password = Hash::make($data['password']);
        if (getSystemSetting('verification') == 'off') {
            $user->email_verified_at = Carbon::now();
        }
        $user->user_type = "Customer";
        $user->save();
        $user->assignGroup(2);

        CustomersController::store($user);
        if (getSystemSetting('verification') == "on" && !$user->email_verified_at) {
            $id = $user->id;
            return view('auth.verify', compact('id'));
        } else {
            return $user;
        }
    }


    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if (isset($verifyUser)) {
            $user = $verifyUser->user;
            if (!$user->verified) {
                $verifyUser->user->email_verified_at = Carbon::now();
                $verifyUser->user->save();
                $status = translate("Your e-mail is verified. You can now login.");
                $verifyUser->delete();
            } else {
                $status = translate("Your e-mail is already verified. You can now login.");
            }
        } else {
            return redirect()->route('login')->with('warning', translate("Sorry your email can not be identified."));
        }
        return redirect()->route('login')->with('status', $status);
    }


    public function sendToken(Request $request)
    {
        $verifyuser = VerifyUser::where('user_id', $request->id)->first();
        if ($verifyuser) {
            $verifyuser->user->notify(new VerifyNotifications($verifyuser->user));
            $resent = translate('A fresh verification link has been sent to your email address.');
        } else {
            $user = User::where('id', $request->id)->first();
            if ($user) {
                //verify email
                $verifyUser = VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => sha1(time())
                ]);
                $verifyuser = VerifyUser::where('user_id', $request->id)->first();
                $verifyuser->user->notify(new VerifyNotifications($verifyuser->user));
                $resent = translate('A fresh verification link has been sent to your email address.');
            } else {
                $resent = translate('User is not Found');
            }

        }
        $id = $request->id;
        return view('auth.verify', compact('id'))->with('resent', $resent);
    }
}
