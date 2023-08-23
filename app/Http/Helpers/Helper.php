<?php

use App\Helper\Helper;
use Illuminate\Support\Facades\Auth;

//this function for open Json file to read language json file
function openJSONFile($code)
{
    $jsonString = [];
    if (File::exists(base_path('resources/lang/' . $code . '.json'))) {
        $jsonString = file_get_contents(base_path('resources/lang/' . $code . '.json'));
        $jsonString = json_decode($jsonString, true);
    }
    return $jsonString;
}

//save the new language json file
function saveJSONFile($code, $data)
{
    ksort($data);
    $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(base_path('resources/lang/' . $code . '.json'), stripslashes($jsonData));
}

//translate the key with json
function translate($key)
{
    $key = ucfirst(str_replace('_', ' ', $key));
    if (File::exists(base_path('resources/lang/en.json'))) {
        $jsonString = file_get_contents(base_path('resources/lang/en.json'));
        $jsonString = json_decode($jsonString, true);
        if (!isset($jsonString[$key])) {
            $jsonString[$key] = $key;
            saveJSONFile('en', $jsonString);
        }
    }

    return __($key);
}

//override or add env file or key
function overWriteEnvFile($type, $val)
{
    $path = base_path('.env'); // get file ENV path
    if (file_exists($path)) {
        $val = '"' . trim($val) . '"';
        if (is_numeric(strpos(file_get_contents($path), $type)) && strpos(file_get_contents($path), $type) >= 0) {
            file_put_contents($path, str_replace($type . '="' . env($type) . '"', $type . '=' . $val, file_get_contents($path)));
        } else {
            file_put_contents($path, file_get_contents($path) . "\r\n" . $type . '=' . $val);
        }
    }
}

//scan directory for load flag
function readFlag()
{
    $dir = base_path('public/images/lang');
    $file = scandir($dir);
    return $file;
}

//auto Rename Flag
function flagRenameAuto($name)
{
    $nameSubStr = substr($name, 8);
    $nameReplace = ucfirst(str_replace('_', ' ', $nameSubStr));
    $nameReplace2 = ucfirst(str_replace('.png', '', $nameReplace));
    return $nameReplace2;
}

//format the Price
function formatPrice($price)
{
    $sc = session('currency');
    if ($sc != null) {
        $id = $sc;
    } else {
        $id = (int)getSystemSetting('default_currencies');
    }

    $currency = App\Models\Currency::find($id);
    $p =$price * $currency->rate;
    return $currency->align == 0 ? number_format($p, 0) . $currency->symbol :  $currency->symbol . number_format($p, 0);
}


/*default*/
function defaultCurrency()
{
    $sc = session('currency');
    if ($sc != null) {
        $id = $sc;
    } else {
        $id = (int)getSystemSetting('default_currencies');
    }
    $currency = \App\Models\Currency::find($id);
    return $currency->code;
}

/*Active Currency*/
function activeCurrency()
{
    $sc = session('currency');
    if ($sc != null) {
        $id = $sc;
    } else {
        $id = (int)getSystemSetting('default_currencies');
    }
    $currency = \App\Model\Currency::find($id);
    return $currency->code;
}

//get system setting data
function getSystemSetting($key)
{
    return \App\Models\Settings::where('name', $key)->first()->value;
}

//get Promotions data
function getPromotions($key)
{
    return App\Models\Promotion::where('type', $key)->Published()->get();
}

//get Promotions data
function getPopup($key)
{
    return App\Models\Promotion::where('type', $key)->Published()->first();
}
//Get file path

//path is storage/app/
function filePath($file)
{
    return asset($file);
}

//delete file
function fileDelete($file)
{
    if ($file != null) {
        if (file_exists(public_path($file))) {
            unlink(public_path($file));
        }
    }
}

//uploads file
// uploads/folder
function fileUpload($file, $folder)
{
    return $file->store('uploads/' . $folder);
}

/*paginate default value*/
function paginate()
{
    return 12;
}

/*paginate default value*/
function sku()
{
    return rand(100000, 1000000);
}
/*calculate as percentage or amount*/
function commissionStatus()
{
    /*todo:here are the setting form admin how to calculate data ase percentage or amount*/
    return true;
}
/*vendor active or disable*/
function sellerStatus()
{
    /*todo::here are the setting vendor active or disable*/
    if (getSystemSetting('seller') == 'enable') {
        return true;
    } else {
        return false;
    }
}
/*seller publish mode*/
function sellerMode()
{
    /*todo::here seller Mode request is true freedom is false if any user issue activate request mode true */
    if (getSystemSetting('seller_mode') == 'request') {
        return true;
    } elseif (getSystemSetting('seller_mode') == 'freedom') {
        return false;
    } else {
        return true;
    }
}
/*customer login status*/
function loginStatus()
{
    /*todo::customer login in modal or not*/
    if (getSystemSetting('login_modal') == "on") {
        return '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Add to cart</button>';
    } else {
        return '<a class="btn btn-warning m-2 p-3 fs-12" href="#">Add to cart a</a>';
    }
}
/*brand Product Price*/
function brandProductPrice($sellers)
{
    $price = collect();
    foreach ($sellers as $min_price) {
        $price->push($min_price->product_price);
    }
    return $price;
}
/*brand Product sale Price*/
function brandProductSalePrice($sellers)
{
    $price = collect();
    foreach ($sellers as $min_price) {
        $price->push($min_price->discount_price);
    }
    return $price;
}

/*show category*/
function categories($items, $type)
{
    if ($items == 0) {
        return App\Models\Category::where('parent_category_id', 0)->Published()->with('childrenCategories')->get();
    }
    return App\Models\Category::where('parent_category_id', 0)->Published()->with('childrenCategories')->take($items)->get();
}
/*show products*/
function brandProducts($items, $slug)
{
    if ($items == 0) {
        return App\Models\Brand::where('slug', $slug)->Published()->with('products')->get();
    }
    return App\Models\Brand::where('slug', $slug)->Published()->with('products')->take($items)->get();
}
/*brands*/
function brands($show)
{
    return App\Models\Brand::Published()->paginate($show);
}
/*brands shuffle*/
function brandsShuffle($showAll)
{
    return App\Models\Brand::Published()->paginate($showAll)->shuffle();
}
/*all products*/
function all_products()
{
    return App\Models\Product::latest()->Published()->paginate(32);
}
/*return sale products*/
function sale_products($paginate)
{
    if (vendorActive()) {
        return App\VendorProduct::with('sale_products')->Published()->Discounted()->paginate($paginate);
    }
    return \App\Models\Product::Published()->Discounted()->paginate($paginate);
}
/*total product count*/
function total_products()
{
    return App\Models\Product::Published()->count();
}
/*total product count*/
function authCart()
{
    try {
        return App\Models\Cart::where('user_id', Auth::user()->id)->count();
    }catch (Exception $exception){
        return 0;
    }
}
/*total product count*/
function authWishlist()
{
    try {
        return App\Models\Wishlist::where('user_id', Auth::user()->id)->count();
    }catch (Exception $exception){
        return 0;
    }
}
/*promotionBanners*/
function promotionBanners($type)
{
    return App\Models\Promotion::where('type', $type)->Published()->paginate(4);
}

/*promotion banners for backend*/
function promotionBannersForBackend($type)
{
    return App\Models\Promotion::where('type', $type)->paginate(4);
}
/*order count*/
function orderCount($type)
{
    if (vendorActive()) {
        $vendor = \App\Vendor::where('user_id', \Illuminate\Support\Facades\Auth::id())->first();
        if ($vendor == null) {
            if ($type == 'count') {
                return App\Models\OrderProduct::count();
            }
            if ($vendor == null) {
                return App\Models\OrderProduct::where('status', $type)->count();
            }
        } else {
            if ($type == 'count') {
                return App\Models\OrderProduct::where('shop_id', $vendor->id)->count();
            }
            return App\Models\OrderProduct::where('status', $type)->where('shop_id', $vendor->id)->count();
        }
    } else {
        if ($type == 'count') {
            return App\Models\EcomOrderProduct::count();
        } else {
            return App\Models\EcomOrderProduct::where('status', $type)->count();
        }
    }
}
/*complainCount*/
function complainCount($type)
{
    return App\Models\Complain::where('status', $type)->count();
}
//show info page in frontend
function infopage($section, $take)
{
    return \App\Models\infopage::where('section', $section)->with('page')->take($take)->get();
}
/*sub category*/
function subCategory()
{
    $cat = \App\Models\Category::where('parent_category_id', 0)->Published()->with('childrenCategories')->get();
    $subCat = collect();
    foreach ($cat as $x) {
        if ($x->childrenCategories->count() > 0) {
            foreach ($x->childrenCategories as $y) {
                if ($y->childrenCategories != null && $y->is_published == 1) {
                    foreach ($y->childrenCategories as $z) {
                        if ($z->childrenCategories != null && $z->is_published == 1 && $z->is_popular == 1) {
                            $subCat->push($z);
                        }
                    }
                }
            }
        }
    }
    return $subCat;
}

//there all ecommerce setting
function vendorActive()
{
    if (env('APP_ACTIVE') == 'ecommerce') {
        return false;
    }
    return true;
}


function shopRating($shop_id){
    $stars_count = App\Models\OrderProduct::where('shop_id', $shop_id)
        ->whereNotNull('review_star')
        ->select('review_star')
        ->get()
        ->toArray();



    $rateArray =[];
    foreach ($stars_count as $star_count)
    {
        $rateArray[]= $star_count['review_star'];
    }
    $sum = array_sum($rateArray);


    $customer_count = App\Models\OrderProduct::where('shop_id', $shop_id)
        ->whereNotNull('review_star')
        ->count();
    if ($customer_count > 0) {
        $result= round($sum/$customer_count);
    }else {
        $result= round($sum/1);
    }
    return $result == 0 ? 1 : $result;
}


//check if guest checkout is allowed
function guestCheckout()
{
    if (env('GUEST_CHECKOUT') == 'YES') {
        return true;
    }
    return false;
}

function newVariationRequest()
{
    return App\Models\Variant::where('is_published', 0)->count();
}

// check Paytm route for Mapping

function paytmRoute()
{
    if (file_exists(base_path('routes/paytm.php'))) {
        return true;
    }else{
        return false;
    }
}

// check Paytm route for blade
function paytmRouteForBlade()
{
    if (file_exists(base_path('routes/paytm.php'))) {
        return true;
    }else{
        return false;
    }
}

// check Paytm route for blade
function paytmActive()
{
    if (env('PAYTM_ACTIVE') == 'YES') {
        return true;
    }
    return false;
}


// check ProductExportImport route for Mapping

function ProductExportImportRoute()
{
    if (file_exists(base_path('routes/productexportimport.php'))) {
        return true;
    }else{
        return false;
    }
}

// check Paytm route for blade
function ProductExportImportActive()
{
    if (env('PRODUCTEXPORTIMPORT_ACTIVE') == 'YES') {
        return true;
    }
    return false;
}


// check ProductExportImport route for Mapping

function SslRoute()
{
    if (file_exists(base_path('routes/sslcommerz.php'))) {
        return true;
    }else{
        return false;
    }
}

// check Paytm route for blade
function SslActive()
{
    if (env('SSL_COMMERZ_ACTIVE') == 'YES') {
        return true;
    }
    return false;
}




//Affiliate Routes
function affiliateRoute()
{
    if (file_exists(base_path('routes/affiliate.php'))) {
        return true;
    }else{
        return false;
    }
}

//Affiliate add-on installed?
function affiliateActive()
{
    if (env('AFFILIATE_MARKETING') == 'YES') {
        return true;
    }
    return false;
}

//get affiliate user
function affiliateUser()
{
    $user = App\Models\AffiliateAccount::where('user_id', Auth::user()->id)->first();
    if(!is_null($user)){
        return true;
    }else{
        return false;
    }
}

//get approved affiliate user
function affiliateApprovedUser()
{
    $user = App\Models\AffiliateAccount::where('user_id', Auth::user()->id)->first();
    if($user->is_approved == 1){
        return true;
    }else{
        return false;
    }
}


//get approved & not blocked affiliate user
function affiliateNotBlockedUser()
{
    $user = App\Models\AffiliateAccount::where('user_id', Auth::user()->id)->first();
    if($user->is_blocked == 0){
        return true;
    }else{
        return false;
    }
}

//get cookie time day
function cookiesLimit(){
    $days = (int)getSystemSetting('affiliate_cookie_limit');
    /*return day*/
    return ($days*1440);
}

// get affiliate commission
function affiliateCommission(){
    $commission = (int)getSystemSetting('affiliate_commission');
    return $commission;
}






function logisticActive()
{
    if (env('LOGISTIC_ACTIVE') == "YES"){
        return true;
    }else{
        return  false;
    }
}


function deliverActive()
{
    if (env('DELIVER_ACTIVE') == "YES"){
        return true;
    }else{
        return false;
    }
}

function userType()
{
    return Auth::user();
}

function userTypeIsDeliver(){

    return userType();
//    return Auth::user();
}

function deliverProcessPick(){
//    if (env('DELIVER_PROCESS') == "YES"){
////        Deliveryman Can Pick the order
//        return true;
//    }
//   Admin Assign the Orders in Deliveryman
    return  false;
}