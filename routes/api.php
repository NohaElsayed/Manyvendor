<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServ iceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


/*slider */
Route::get('sliders', 'api\FrontEndController@get_slider');
Route::get('status', function (){
    return response(['status'=>env('APP_ACTIVE')],200);
});
//campaigns
Route::get('campaigns', 'api\FrontEndController@get_campaign');
/*brands*/
Route::get('brands', 'api\FrontEndController@get_brand');
/*trending category*/
Route::get('trending/categories', 'api\FrontEndController@get_trending_cat');
/*all category*/
Route::get('categories', 'api\FrontEndController@all_category');

/*districts*/
Route::get('districts', 'api\FrontEndController@districts');
//city
Route::get('city/{id}', 'api\FrontEndController@get_division_area');
/*get_logistics*/
Route::get('logistic/{id}/{areaId}', 'api\FrontEndController@get_logistics');
/*payment configuration*/
Route::get('payment/setting', 'api\FrontEndController@getPaymentSetting');

/*coupon*/
Route::post('coupon/store', 'api\FrontEndController@coupon_store')->middleware('auth:api');
/*registration customer*/
Route::post('/register', 'api\FrontEndController@register');
/*login customer*/
Route::post('/login', 'api\FrontEndController@login');
//logout
Route::post('/logout', 'api\FrontEndController@logout')->middleware('auth:api');
/*change password*/
Route::post('change/password', 'api\FrontEndController@changePassword')->middleware('auth:api');

/*user data */
Route::post('user/data', 'api\FrontEndController@getData')->middleware('auth:api');
Route::post('update/image', 'api\FrontEndController@updateImage')->middleware('auth:api');
Route::post('update/user', 'api\FrontEndController@updateUser')->middleware('auth:api');

/*forget password*/
Route::get('1/forget/password/{email}','api\FrontEndController@sentForgetCode');
Route::get('2/forget/password/{email}/{code}','api\FrontEndController@matchForgetCode');
Route::post('3/forget/password','api\FrontEndController@saveForgetCodePassword');

if (vendorActive()) {
    /*vendor active*/
    Route::get('trending/products', 'api\ShopController@trendingProducts');
    /*vendor shop product*/
    Route::get('shop/product/{id}', 'api\ShopController@vendor_shop_product');
    /*single product*/
    Route::get('/product/{id}', 'api\ShopController@single_product');
    /*shop brand*/
    Route::get('/brand/{slug}', 'api\ShopController@brand_shop');
    /*shop*/
    Route::get('shops', 'api\ShopController@get_shops');
    /*category ways vendor product*/
    Route::get('shop/cat/product/{id}', 'api\ShopController@get_cat_product');
    /*vendor campaign*/
    Route::get('campaign/{id}', 'api\ShopController@campaign_product');
    /*search_product*/
    Route::get('search/product/{name}', 'api\ShopController@search_product');
    /*wishlist*/
    Route::post('wishlist', 'api\ShopController@wishlist');
    //carts
    Route::get('shop/carts/{carts}', 'api\ShopController@cart_product');
    /*checkout*/
    Route::post('checkout', 'api\ShopController@checkout')->middleware('auth:api');
    /*order list*/
    Route::get('order/list', 'api\ShopController@orderList')->middleware('auth:api');

    //sslcommerz payment
    Route::post('checkout/sslcommerz', 'api\TextController@index')
        ->middleware('auth:api');
}

else {
    /*ecommerce active ok */
    Route::get('trending/products', 'api\EcommerceController@trendingProducts');
    /*single product*/
    Route::get('/product/{id}', 'api\EcommerceController@single_product');
    /*stock id*/
    Route::get('variant/stock/id/{variant}/{productId}', 'api\EcommerceController@variant_by_stock');
    /*ecommerce  brand product ok*/
    Route::get('/brand/{slug}', 'api\EcommerceController@brand_product');

    /*category ways product ok*/
    Route::get('shop/cat/product/{id}', 'api\EcommerceController@get_cat_product');

    /*vendor campaign new ok*/
    Route::get('campaign/{id}', 'api\EcommerceController@campaign_product');
    /*search_product*/
    Route::get('search/product/{name}', 'api\EcommerceController@search_product');
    /*wishlist ok*/
    Route::post('wishlist', 'api\EcommerceController@wishlist');
    //carts
    Route::get('shop/carts/{carts}', 'api\EcommerceController@cart_product');
    /*checkout*/
    Route::post('checkout', 'api\EcommerceController@checkout')->middleware('auth:api');
    /*order list*/
    Route::get('order/list', 'api\EcommerceController@orderList')->middleware('auth:api');
}