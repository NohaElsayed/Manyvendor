<?php

namespace App\Http\Controllers\frontend\customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderProduct;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Alert;

class CustomersController extends Controller
{
    //show customer
    public function index()
    {
        $customer = Customer::where('user_id', Auth::id())->first();
        return view('frontend.customer.index', compact('customer'));
    }


    //add customer to database
    public static function store($user)
    {
        $customer = new Customer;

        $customer->user_id = $user->id;
        $customer->email = $user->email;
        $customer->slug = $user->slug;
        $customer->name = $user->name;

        $customer->save();
        return redirect()->route('homepage');
    }


    //update customer info
    public function update(Request $request)
    {
//        return $request;
        $customer = Customer::where('slug', $request->slug)->first();
        $request->validate([
            'name' => 'required|string',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'confirmed',
        ], [
            'name.required' => translate('Your name is required'),
            'avatar.image' => translate('Please upload a valid image file with jpg, jpeg, png, gif extension.'),
            'avatar.mimes' => translate('Please upload a valid image file with jpg, jpeg, png, gif extension.'),
            'avatar.max' => translate('Maximum image size 2MB.'),
            'password.confirmed' => translate('Password doesn\'t match.'),
        ]);

        $slug = Str::slug($request->name);
        //slug save
        $person = Customer::where('slug', $slug)->get();
        if ($person->count() > 0) {
            $slug1 = $slug . ($person->count() + 1);
        } else {
            $slug1 = $slug;
        }

        //DB::Customer updating
        $customer->name = $request->name;
        $customer->slug = $slug1;

        if ($request->hasFile('avatar')) {
            if (!is_null($customer->avatar)) {
                fileDelete($customer->avatar);
            }
            $customer->avatar = fileUpload($request->avatar, 'customer_avatar');
        } else {
            $customer->avatar = $request->oldAvatar;
        }

        $customer->phn_no = $request->phn_no;
        $customer->address = $request->address;

        $customer->save();


        //DB::User updating
        $user = User::where('slug', $request->slug)->first();
        $user->name = $request->name;
        $user->nationality = $request->nationality;
        $user->slug = $slug1;
        $user->tel_number = $customer->phn_no;

        if (!is_null($request->password)) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if (!is_null($user->avatar)) {
                fileDelete($user->avatar);
            }
            $user->avatar = fileUpload($request->avatar, 'user_avatar');
        } else {
            $user->avatar = $request->oldAvatar;
        }

        $user->save();
        Alert::success(translate('Successful'), translate('Profile Updated Successfully'));
        return redirect()->route('customer.index');
    }

}
