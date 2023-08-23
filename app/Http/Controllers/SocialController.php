<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Validator, Redirect, Response, File;
use Socialite;
use App\User;
use Hash;
use App\Models\Customer;

class SocialController extends Controller
{

    /*redirect url*/
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /*Socialite callback*/
    public function callback($provider)
    {

        $getInfo = Socialite::driver($provider)->user();

        $user = User::where('provider_id', $getInfo->id)->first();

        $user = User::where('email', $getInfo->getEmail())->first();

          if ($user === null) {

                $user = new User();
                $user->name = $getInfo->name;
                $user->slug = Str::slug($getInfo->name);
                $user->email = $getInfo->email;
                $user->provider_id = $getInfo->id;
                $user->provider = $provider;
                $user->password = Hash::make($getInfo->id);
                $user->user_type = 'Customer';
                $user->avatar = $getInfo->getAvatar();
                $user->slug = Str::slug($getInfo->name);
                $user->save();

                $customer = new Customer();
                $customer->name = $getInfo->name;
                $customer->email = $getInfo->email;
                $customer->user_id = $user->id;
                $customer->avatar = $getInfo->getAvatar();
                $customer->slug = Str::slug($getInfo->name);
                $customer->save();

            }else{

                if ($user->user_type == 'Customer') {
                    //storing User
                    User::where('email', $user->email)->update([
                        'name' => $getInfo->name,
                        'email' => $getInfo->email,
                        'user_type' => 'Customer',
                        'provider_id' => $getInfo->id,
                        'provider' => $provider,
                        'avatar' => $getInfo->getAvatar(),
                        'slug' => Str::slug($getInfo->name),
                    ]);

                        //storing Customer
                        Customer::where('email', $getInfo->getEmail())->update([
                        'name' => $getInfo->name,
                        'email' => $getInfo->email,
                        'slug' => Str::slug($getInfo->name),
                        'avatar' => $getInfo->getAvatar(),
                    ]);
                }
            }

        auth()->login($user);

        return redirect()->to('/');

    }

    //END
}
