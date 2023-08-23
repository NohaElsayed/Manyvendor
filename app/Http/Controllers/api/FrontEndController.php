<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Http\Resources\CampaignResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\LogisticResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\ThanaResource;
use App\Http\Resources\TrendingCategoryResource;
use App\Http\Resources\VendorProductResource;
use App\Http\Resources\VendorResource;
use App\Models\Brand;
use App\Models\Campaign;
use App\Models\Coupon;
use App\Models\Demo;
use App\Models\District;
use App\Models\Logistic;
use App\Models\LogisticArea;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Customer;
use App\Models\Thana;
use App\Notifications\ResetPasswordForMobile;
use App\Notifications\VerifyNotifications;
use App\User;
use App\VerifyUser;
use Braintree\ClientToken;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;
use Hash;


class FrontEndController extends Controller
{
    //get all slider
    public function get_slider()
    {
        $sliders = Promotion::where('type', 'mainSlider')->where('is_published', 1)->get();
        return SliderResource::collection($sliders);
    }

    /*get all setting*/
    public function getPaymentSetting()
    {

        $demo = new Demo();
        /*this stripe*/
        if (!empty(env('STRIPE_KEY')) && !empty(env('STRIPE_KEY'))) {
            $demo->stripeActive = true;
        } else {
            $demo->stripeActive = false;
        }
        $demo->STRIPE_KEY = env('STRIPE_KEY');
        $demo->STRIPE_SECRET = env('STRIPE_SECRET');

        /*this paypal*/
        if (!empty(env('PAYPAL_CLIENT_ID')) && !empty(env('PAYPAL_ENVIRONMENT')) && !empty(env('PAYPAL_APP_SECRET'))) {
            $demo->paypalActive = true;
        } else {
            $demo->paypalActive = false;
        }
        $demo->PAYPAL_CLIENT_ID = env('PAYPAL_CLIENT_ID');
        $demo->PAYPAL_ENVIRONMENT = env('PAYPAL_ENVIRONMENT');
        $demo->PAYPAL_APP_SECRET = env('PAYPAL_APP_SECRET');
        /*this paytm*/
        if (!empty(env('PAYTM_ENVIRONMENT'))
            && !empty(env('PAYTM_MERCHANT_ID'))
            && !empty(env('PAYTM_MERCHANT_KEY')) &&
            !empty(env('PAYTM_MERCHANT_WEBSITE')) &&
            !empty(env('PAYTM_CHANNEL')) &&
            !empty(env('PAYTM_INDUSTRY_TYPE'))) {
            $demo->paytmActive = true;
        } else {
            $demo->paytmActive = false;
        }
        $demo->PAYTM_ENVIRONMENT = env('PAYTM_ENVIRONMENT');
        $demo->PAYTM_MERCHANT_ID = env('PAYTM_MERCHANT_ID');
        $demo->PAYTM_MERCHANT_KEY = env('PAYTM_MERCHANT_KEY');
        $demo->PAYTM_MERCHANT_WEBSITE = env('PAYTM_MERCHANT_WEBSITE');
        $demo->PAYTM_CHANNEL = env('PAYTM_CHANNEL');
        $demo->PAYTM_INDUSTRY_TYPE = env('PAYTM_INDUSTRY_TYPE');

        /*this stripe*/
        if (!empty(env('STORE_ID')) && !empty(env('STORE_PASSWORD'))) {
            $demo->sslActive = true;
        } else {
            $demo->sslActive = false;
        }
        $demo->STORE_ID = env('STORE_ID');
        $demo->STORE_PASSWORD = env('STORE_PASSWORD');

        return $demo;
    }

    /*get campaign*/
    public function get_campaign()
    {
        $campaigns = Campaign::where('active_for_customer', 1)->On()->orderBy('start_from', 'asc')->get();
        return CampaignResource::collection($campaigns);
    }

    /*get brands*/
    public function get_brand()
    {

        $brands = Brand::Published()->get();
        return BrandResource::collection($brands);
    }


    //get_trending_cat
    public function get_trending_cat()
    {
        return TrendingCategoryResource::collection(subCategory());
    }


    //all category
    public function all_category()
    {

        $catOne = collect();
        foreach (categories(0, null) as $category) {
            if ($category->childrenCategories->count() > 0) {
                //here are the push data in collection 1st
                $one = new Demo();
                $one->name = $category->name;
                $one->id = $category->id;
                $catTwo = collect();
                foreach ($category->childrenCategories as $pCat) {
                    if ($pCat->childrenCategories->count() > 0) {
                        //here are the push data in collection 2nd

                        $tow = new Brand();
                        $tow->name = $pCat->name;
                        $tow->id = $pCat->id;
                        $catThree = collect();
                        foreach ($pCat->childrenCategories as $cCat) {
                            if ($cCat != null) {
                                // here are the push data in collection 3rd
                                $three = new Product();
                                $three->id = $cCat->id;
                                $three->name = $cCat->name;
                                $catThree->push($three);
                            }
                        }
                        $tow->child = $catThree;
                        $catTwo->push($tow);
                    }
                }
                $one->parent = $catTwo;
                $catOne->push($one);
            }
        }
        return CategoryResource::collection($catOne);

    }


    /*apply coupon*/
    public function coupon_store(Request $request)
    {

        $coupon = Coupon::where('code', $request->coupon)->Published()->first();
        $demo = new demo();
        if ($coupon != null) {
            $start_day = Carbon::create($coupon->start_day);
            $end_day = Carbon::create($coupon->end_day);
            $min_value = $coupon->min_value;

            if (Carbon::now() > $start_day && Carbon::now() < $end_day) {
                if ($min_value <= $request->total) {
                    $demo->coupon = $coupon->code;
                    $demo->discount = $coupon->discount($coupon->rate);
                    $demo->after_discount = ($request->total - $demo->discount);
                    $demo->error = false;
                } else {
                    $demo->error = true;
                    $demo->message = 'Minimum Amount ' . ' ' . $min_value . ' ' . 'needed';
                }
            } else {
                $demo->error = true;
                $demo->message = 'Coupon expired.';

            }
        } else {
            $demo->error = true;
            $demo->message = 'Invalid Coupon Code.';
        }
        $demo->total = $request->total;
        return $demo;
    }

    /*districts*/
    public function districts()
    {
        $data = District::all();
        return DistrictResource::collection($data);
    }

    /*city*/
    // get_division_area
    public function get_division_area($id)
    {
        $thanas = Thana::where('district_id', $id)->get();
        return ThanaResource::collection($thanas);
    }


    // get_logistics
    public function get_logistics($id, $areaId)
    {

        $logistics = LogisticArea::where('division_id', $id)
            ->Active()
            ->get();

        $dataSend = collect();

        foreach ($logistics as $logistic) {
            $x = json_decode($logistic->area_id);
            foreach ($x as $area) {
                if ($area == $areaId) {
                    $vf = Logistic::where('id', $logistic->logistic_id)->first();
                    $demo = new Demo();
                    $demo->rate = $logistic->rate;
                    $demo->id = $vf->id;
                    $demo->name = $vf->name;
                    $demo->days = $logistic->min . '-' . $logistic->max . ' Days';
                    $dataSend->push($demo);
                }
            }
        }

        return LogisticResource::collection($dataSend);
    }
    // User Auth


    /**
     * REGISTER
     */

    public function register(Request $request)
    {
        $demo = new Demo();
        if ($request->name == null) {
            $demo->error = true;
            $demo->errorMessage = "UserName must be required";
        } elseif ($request->email == null) {
            $demo->error = true;
            $demo->errorMessage = "Email must be required";
        } else {
            $userhave = User::where('email', $request->email)->first();
            if ($userhave != null) {
                $demo->error = true;
                $demo->errorMessage = "Email is All ready entry";
            } else {
                $userns = User::where('name', $request->name)->count();
                $user = new User();
                $user->user_type = "Customer";
                $user->name = $request->name;
                $user->email = $request->email;
                if ($userns != null) {
                    $user->slug = Str::slug($user->name) . '_' . (int)($userns + 1);
                } else {
                    $user->slug = Str::slug($user->name);
                }
                $user->password = Hash::make($request->password);
                $user->save();

                $customer = new Customer();
                $customer->user_id = $user->id;
                $customer->name = $user->name;
                $customer->email = $user->email;
                $customer->slug = $user->slug;
                $customer->save();

                /*append demo data*/
                /*here to check*/
                if (getSystemSetting('verification') == "on" && !$user->email_verified_at) {
                    try {
                        $verifyUser = VerifyUser::create([
                            'user_id' => $user->id,
                            'token' => sha1(time())
                        ]);
                        $verifyuser = VerifyUser::where('user_id', $user->id)->first();
                        $verifyuser->user->notify(new VerifyNotifications($verifyuser->user));
                        $demo->errorMessage = 'A fresh verification link has been sent to your email address.';
                    } catch (\Exception $exception) {
                        $demo->errorMessage = "Registrations Successfully is Done";
                    }
                } else {
                    $demo->errorMessage = "Registrations Successfully is Done";
                }
                $demo->error = false;
            }
        }

        return $demo;
    }


    /**
     * LOGIN
     */

    public function login(Request $request)
    {
        $demo = new Demo();

        $credentials = [
            'email' => $request['email'],
            'password' => $request['password'],
        ];

        if (auth()->attempt($credentials) == false ) {
            $demo->error = true;
            $demo->errorMessage = "Invalid Credentials";
        } else {
            $user = Auth::user();
            if ($user->user_type == "Customer") {
                /*here to check*/
                $demo->error = false;
                if (getSystemSetting('verification') == "on" && !$user->email_verified_at) {
                    try {
                        $verifyuser = VerifyUser::where('user_id', $user->id)->first();
                        if ($verifyuser) {
                            $verifyuser->user->notify(new VerifyNotifications($verifyuser->user));
                            $demo->errorMessage = 'A fresh verification link has been sent to your email address.';
                        } else {
                            $verifyUser = VerifyUser::create([
                                'user_id' => $user->id,
                                'token' => sha1(time())
                            ]);
                            $verifyuser = VerifyUser::where('user_id', $user->id)->first();
                            $verifyuser->user->notify(new VerifyNotifications($verifyuser->user));
                            $demo->errorMessage = 'A fresh verification link has been sent to your email address.';

                        }
                        $demo->token = null;
                    } catch (\Exception $exception) {
                        $demo->errorMessage = "There are Some Problem. Try again!";
                    }

                } else {
                    /*append demo data*/
                    $demo->name = $user->name;
                    $demo->email = $user->email;
                    $demo->avatar = $user->avatar == null ? null : filePath($user->avatar);
                    $token = $user->createToken(env('API_TOKEN'))->accessToken;
                    $demo->token = $token;
                    $demo->errorMessage = "Successfully Login Done";
                }
            } else {
                $demo->error = true;
                $demo->errorMessage = "Invalid Credentials";
            }
        }
        return $demo;
    }


    public function logout()
    {
        $user = Auth::user()->token();
        $user->revoke();
        return response(['message' => 'Logout successfully']);
    }

    // User Auth:END

    /*change password*/
    public function changePassword(Request $request)
    {
        $demo = new Demo();
        if ($request->newPassword == null) {
            $demo->error = true;
            $demo->message = 'New Password Is Required';
        } else {
            if (\Illuminate\Support\Facades\Hash::check($request->currentPassword, Auth::user()->getAuthPassword())) {
                $user = User::find(Auth::id());
                $user->password = \Illuminate\Support\Facades\Hash::make($request->newPassword);
                $user->save();

                $demo->error = false;
                $demo->message = 'New Password Is saved';
            } else {
                $demo->error = true;
                $demo->message = 'Current Password Is not Match';
            }
        }

        return $demo;

    }

    /*get data*/
    public function getData(Request $request)
    {
        $demo = new Demo();
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $demo->name = $user->name;
        $demo->phone = $customer->phn_no;
        $demo->address = $customer->address;
        $demo->avatar = filePath($user->avatar);
        return $demo;

    }


    /*upldate image*/
    public function updateImage(Request $request)
    {
        $user = Auth::user();
        $user->avatar = fileUpload($request->picture, 'user_avatar');
        $user->save();
        $customer = Customer::where('user_id', $user->id)->first();
        $customer->avatar = fileUpload($request->picture, 'user_avatar');
        $customer->save();
        return [$request, $request->hasFile('picture')];
    }

    public function updateUser(Request $request)
    {
        $demo = new Demo();
        if ($request->name == null) {
            $demo->error = true;
            $demo->errorMessage = 'Name is Required';
        } else {
            $user = Auth::user();
            $user->name = $request->name;
            $user->slug = $request->name . $user->id;
            $user->tel_number = $request->phone;
            $user->save();
            $customer = Customer::where('user_id', $user->id)->first();
            $customer->name = $request->name;
            $customer->slug = $user->slug;
            $customer->phn_no = $request->phone;
            $customer->address = $request->address;
            $customer->save();

            $demo->error = false;
            $demo->name = $user->name;
            $demo->email = $user->email;
            $demo->avatar = $user->avatar == null ? null : filePath(auth()->user()->avatar);
            $token = Auth::user()->createToken(env('API_TOKEN'))->accessToken;
            $demo->token = $token;
        }

        return $demo;
    }


    /*password reset*/
    public function sentForgetCode($email)
    {
        $user = User::where('email', $email)->where('user_type', 'Customer')->first();
        $demo = new Demo();
        if ($user != null) {

            $id = rand(10, 100000);
            /*send here email and insert the code in */
            try {
                $user->notify(new ResetPasswordForMobile($id));
                $user->fcode = $id;
                $user->save(); //save the code
                $demo->error = false;
                $demo->message = "An Activation code is already sent to your email, Please check your email";
            } catch (\Exception $exception) {
                $demo->error = true;
                $demo->message = 'There are Some Problem. Try again!';
            }
        } else {
            $demo->error = true;
            $demo->message = 'Email Not Found';
        }
        return $demo;
    }


    public function matchForgetCode($email, $code)
    {
        $user = User::where('email', $email)->where('user_type', 'Customer')->where('fcode', $code)->first();
        $demo = new Demo();
        if ($user != null) {
            $demo->error = false;
            $demo->message = "Type your new password";
        } else {
            $demo->error = true;
            $demo->message = 'Invalid Code';
        }
        return $demo;
    }


    public function saveForgetCodePassword(Request $request)
    {
        $user = User::where('email', $request->email)
            ->where('user_type', 'Customer')
            ->where('fcode', $request->code)->first();
        $demo = new Demo();
        if ($user != null) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $user->fcode = null;
            $user->save();
            $demo->error = false;
            $demo->message = "Password Is Updated";
        } else {
            $demo->error = true;
            $demo->message = 'Invalid Attempt. Try again!';
        }
        return $demo;
    }


}
