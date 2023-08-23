<?php

namespace App\Http\Controllers;

use App\Notifications\VerifyNotifications;
use App\VerifyUser;
use Illuminate\Http\Request;
use App\Http\Requests\VendorRequest;
use App\Vendor;
use App\VendorProduct;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Variant;
use App\Models\OrderProduct;
use Mail;
use App\Mail\NewVendorMail;
use App\User;
use Hash;
use Auth;
use Alert;
use Carbon\Carbon;
use Illuminate\Support\Str;

class VendorController extends Controller
{
    // signup form
    public function signup()
    {
        return view('frontend.seller.register');
    }

    // vendor form store
    public function store(VendorRequest $request)
    {

        // Retrieve the validated input data...
        $validated = $request->validated();

        $vendor = new Vendor();
        $vendor->name = $request->name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->shop_name = $request->shop_name;
        $vendor->address = $request->address;
        $vendor->trade_licence = $request->trade_licence;
        $vendor->slug = Str::slug($request->shop_name);
        if ($request->hasFile('shop_logo')) {
            $vendor->shop_logo = fileUpload($request->shop_logo, 'shop_logo');
        }
        $vendor->created_at = Carbon::now();
        $vendor->save();

        return redirect()->route('vendor.success');
    }

    // seller requests
    public function requests()
    {
        $vendor_requests = Vendor::where('approve_status', 0)->get();
        return view('backend.sellers.requests', compact('vendor_requests'));
    }

    // seller requests
    public function requests_view($id)
    {
        $single_request_vendor = Vendor::where('id', $id)->first();
        return view('backend.sellers.request_view', compact('single_request_vendor'));
    }

    public function requests_view2($id)
    {
        $single_request_vendor = Vendor::where('user_id', $id)->first();
        return view('backend.sellers.request_view2', compact('single_request_vendor'));
    }

    // seller requests accept
    public function accept(Request $request, $id)
    {
        $password_generate = Str::random(6);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->slug = Str::slug($request->name);
        $user->tel_number = $request->phone;
        $user->password = bcrypt($password_generate);
        $user->email_verified_at = Carbon::now();
        $user->user_type = 'Vendor';
        $user->created_at = Carbon::now();
        $user->save();

        /*assign group*/
        $user->assignGroup(3);

        $accept_vendor = Vendor::where('id', $id)->firstOrFail();
        $accept_vendor->approve_status = 1;
        $accept_vendor->shop_logo = $request->shop_logo;
        $accept_vendor->address = $request->address;
        $accept_vendor->user_id = $user->id;
        $accept_vendor->save();

        try {
            Mail::to($request->email)->send(new NewVendorMail($password_generate));
        }catch (\Exception $exception){}
        return redirect()->route('vendor.requests');
    }

    // after seller registration redirect here
    public function reg_success()
    {
        return view('frontend.seller.success');
    }

    // seller profile
    public function profile()
    {
        $seller_profile = User::with('vendor')->findOrFail(Auth::user()->id);
        return view('backend.sellers.profile.profile', compact('seller_profile'));
    }

    // Seller create manually
    public function create()
    {
        return view('backend.sellers.create');
    }

    // Seller create manually store
    public function vendor_store(VendorRequest $request)
    {

        $password_generate = Str::random(6);
        $slug = Str::slug($request->name);


        $seller_as_user = new User();
        $seller_as_user->name = $request->name;
        $seller_as_user->email = $request->email;
        $seller_as_user->genders = $request->genders;
        $seller_as_user->password = bcrypt($password_generate);
        $seller_as_user->nationality = $request->nationality;
        $seller_as_user->slug = $slug;

        $person = User::where('slug', $slug)->get();
        if ($person->count() > 0) {
            $slug1 = $slug . ($person->count() + 1);
        } else {
            $slug1 = $slug;
        }

        $seller_as_user->user_type = 'Vendor';
        $seller_as_user->created_at = Carbon::now();
        $seller_as_user->save();

        /*assign group*/
        $seller_as_user->assignGroup(3);

        $seller_create = new Vendor();
        $seller_create->shop_name = $request->shop_name;
        $seller_create->name = $request->name;
        $seller_create->email = $request->email;
        $seller_create->phone = $request->phone;
        $seller_create->trade_licence = $request->trade_licence;
        $seller_create->address = $request->address;
        $seller_create->about = $request->about;
        $seller_create->facebook = $request->facebook;
        $seller_create->approve_status = 1;
        $seller_create->user_id = $seller_as_user->id;
        $seller_create->slug = Str::slug($request->shop_name);

        if ($request->hasFile('shop_logo')) {
            $seller_create->shop_logo = fileUpload($request->shop_logo, 'shop_logo');
        }

        $seller_create->save();

        try {
            Mail::to($request->email)->send(new NewVendorMail($password_generate));
        }catch (\Exception $exception){}

        //send verification mail
        $verifyuser = VerifyUser::where('user_id', $seller_as_user->id)->first();
        if ($verifyuser) {
            $verifyuser->user->notify(new VerifyNotifications($verifyuser->user));
        } else {
            $user = User::where('id',$seller_as_user->id)->first();
            if ($user) {
                //verify email
                $verifyUser = VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => sha1(time())
                ]);
                $verifyuser = VerifyUser::where('user_id',$seller_as_user->id)->first();
                $verifyuser->user->notify(new VerifyNotifications($verifyuser->user));
            }
        }

        return back();
    }

    // seller profile update
    public function seller_update(Request $request)
    {
        $seller_vendor = Vendor::where('user_id', Auth::user()->id)->firstOrFail();
        $seller_vendor->email = $request->email;
        $seller_vendor->phone = $request->phone;
        $seller_vendor->address = $request->address;
        $seller_vendor->about = $request->about;
        $seller_vendor->facebook = $request->facebook;
        if ($request->hasFile('shop_logo')) {
            $seller_vendor->shop_logo = fileUpload($request->shop_logo, 'shop_logo');
        }
        $seller_vendor->save();

        $vendor_as_user = User::where('id', Auth::user()->id)->firstOrFail();
        $vendor_as_user->email = $request->email;
        $vendor_as_user->genders = $request->genders;
        $vendor_as_user->nationality = $request->nationality;
        if ($request->password != null){
            $request->validate([
                'password' => ['required', 'string', 'confirmed'],
            ],[
                'password.confirmed'=>'Password confirmation does not match',
            ]);
            $vendor_as_user->password = Hash::make($request->password);
        }

        $vendor_as_user->save();
        return back()->with('success', translate('Profile updated successfully'));
    }

    // seller list
    public function all_seller()
    {
        $sellers = User::where('user_type', 'Vendor')->with('vendor')->get();
        return view('backend.sellers.all_seller', compact('sellers'));
    }

    // seller shops
    public function seller_shops(Request  $request)
    {

        if($request->search != null){
            $ids = array();
            $vendor = Vendor::where('shop_name','LIKE', '%' . $request->search . '%')->get();
            foreach ($vendor as $v){
                array_push($ids,$v->user_id);
            }
            $seller_shops = User::whereIn('id',$ids)->where('user_type', 'Vendor')->get();
        }else{
            $seller_shops = User::where('user_type', 'Vendor')->get()->shuffle();
        }

        return view('frontend.seller.seller_shops', compact('seller_shops'));
    }

    // seller shop
    public function seller_shop($slug)
    {
        $seller_store = Vendor::where('slug', $slug)->first();
        $products = VendorProduct::where('user_id', $seller_store->user_id)->with('products')->paginate(16);
        return view('frontend.seller.seller_shop', compact('seller_store', 'products'));
    }


    // Seller product upload
    public function seller_product_store(Request $request)
    {

        $check_exist = VendorProduct::where('product_id', $request->product_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        $discount_price = $request->product_price - $request->discount_price;
        $discount_percentage = $discount_price * 100 / $request->product_price;

        if (isset($check_exist)) {
            Alert::success('Exist', 'Product already exist');
            return back();
        } else {
            $seller_product_upload = new VendorProduct();
            $seller_product_upload->user_id = Auth::user()->id;
            $seller_product_upload->parent_id = $request->parent_id;
            $seller_product_upload->category_id = $request->category_id;
            $seller_product_upload->product_id = $request->product_id;
            $seller_product_upload->product_price = $request->product_price;
            $seller_product_upload->quantity = $request->quantity;

            if ($request->is_discount == 'on') {
                $seller_product_upload->is_discount = true;
            } else {
                $seller_product_upload->is_discount = false;
            }

            if ($request->is_discount == 'on') {
                $seller_product_upload->discount_price = $request->discount_price;
            } else {
                $seller_product_upload->discount_price = null;
            }

            if ($request->is_discount == 'on') {
                $seller_product_upload->discount_percentage = $discount_percentage;
            } else {
                $seller_product_upload->discount_percentage = null;
            }

            Alert::success('Done', 'Product uploaded successfully');
            $seller_product_upload->save();
            return back();
        }
    }

    // seller_products
    public function seller_products()
    {
        $seller_products = VendorProduct::where('user_id', Auth::id())
            ->with('product')
            ->with('parent_category')
            ->with('sub_category')
            ->get();
        return view('backend.sellers.products.seller_products', compact('seller_products'));
    }

    // seller_product_edit
    public function seller_product_edit($id)
    {
        $brands = Brand::Published()->get();
        $catGroup = Category::where('parent_category_id', 0)->Published()->with('frontParentCat')->get();
        $categories = collect();
        foreach ($catGroup as $group) {
            if ($group->frontParentCat->count() > 0) {
                foreach ($group->frontParentCat as $item) {
                    $categories->push($item);
                }
            }
        }

        /*variant show*/
        $variants = Variant::all();
        $seller_product = VendorProduct::where('id', $id)->first();

        return view('backend.sellers.products.seller_product_edit', compact('brands', 'categories', 'variants', 'seller_product'));
    }


    /*vendor banned*/
    public function vendorBanned($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            if ($user->banned == true) {
                $mess = translate('Seller is Banned');
                $user->banned == false;
            } else {
                $mess = translate('Seller is Activated');
                $user->banned = true;
            }
            $user - save();
        }
        return back()->with('success', $mess);
    }

    //END
}
