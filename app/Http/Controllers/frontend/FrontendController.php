<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\District;
use App\Models\Page;
use App\Models\SectionSettings;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use App\Models\VendorProductVariantStock;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use File;

class FrontendController extends Controller
{



    /*index homepage route*/
    public function index()
    {
/*here json*/
//        $jsonString = [];
//        if (File::exists(base_path('public/states_titlecase.json'))) {
//            $jsonString = file_get_contents(base_path('public/states_titlecase.json'));
//            $jsonString = json_decode($jsonString, true);
//        }
//        foreach ($jsonString as $natok){
////            return $natok;
//            $d = new District();
//            $d->district_name = $natok['name'];
//            $d->save();
//        }
//        return $jsonString;
        /*section show*/
        $sections =SectionSettings::orderBy('sort')->get();

        return view('frontend.homepage.index',compact('sections'));
    }

    /*check the login credential*/
    public function loginCheck(Request $request){

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response(['ok'=>true],200);
        }
        \auth()->logout();
        return response(['ok'=>false,'message'=>translate('Credential not match')],200);

    }


    /*campaign product variant*/
    public function variantPro($vendor_id,$vendor_product_id,$campaign_id){
        $vpstock = VendorProductVariantStock::where('user_id',$vendor_id)->where('vendor_product_id',$vendor_product_id)->get();
        return view('frontend.campaign.variantProduct',compact('vpstock','campaign_id'));
    }



    /*currency change*/
    public function currencyChange(Request $request){
        session(['currency' => $request->code]);
        Artisan::call('optimize:clear');
        return back();
    }

    /*languages change in session*/
    public function languagesChange(Request $request)
    {
        session(['locale' => $request->code]);
        Artisan::call('optimize:clear');
        return back();
    }


    /*page*/
    public function page($slug){
        $page = Page::where('slug',$slug)->with('content')->first();
        return view('frontend.page',compact('page'));
    }


    /**
     * BRANDS
     */
    public function brands(Request $request){
        if ($request->search != null){
            $brands = Brand::where('name','like','%'.$request->search.'%')->get();
        }else{
            $brands = Brand::all()->shuffle();
        }
        return view('frontend.brands.index',compact('brands'));
    }

}
