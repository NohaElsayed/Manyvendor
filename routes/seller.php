<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => ['auth', 'installed', 'permissions:seller'], 'prefix' => 'dashboard/seller'], function () {

    Route::get('', 'HomeController@sellerDashboard')->name('seller.dashboard');
    //brands
    Route::get('products/brands/create', 'backend\seller\products\BrandsController@create')->name('seller.brands.create');
    Route::post('products/brands/store', 'backend\seller\products\BrandsController@store')->name('seller.brands.store')->middleware('demo');


    //campaign
    Route::get('campaigns', 'backend\seller\campaign\CampaignsController@index')->name('seller.campaign.index');
    Route::get('campaigns/request', 'backend\seller\campaign\CampaignsController@create')->name('seller.campaign.create');
    Route::post('campaigns/request', 'backend\seller\campaign\CampaignsController@campaignRequest')->name('seller.campaign.store')->middleware('demo');
    Route::get('campaigns/search', 'backend\seller\campaign\CampaignsController@search')->name('seller.campaign.search');
    Route::get('campaigns/add-products/{campaign_slug}', 'backend\seller\campaign\CampaignsController@indexProducts')->name('seller.campaign.products.index');
    Route::post('campaigns/add-products', 'backend\seller\campaign\CampaignsController@store')->name('seller.campaign.products.store'); //ajax
    Route::post('campaigns/remove-product', 'backend\seller\campaign\CampaignsController@destroy')->name('seller.campaign.products.destroy'); //ajax
    Route::get('campaigns/product-search', 'backend\seller\campaign\CampaignsController@searchProducts')->name('seller.campaign.products.search');


    // Vendor product upload
    Route::get('product/upload', 'backend\seller\products\ProductController@seller_product_upload')
        ->name('seller.product.upload');
    // Vendor product store
    Route::post('product/upload/store', 'backend\seller\products\ProductController@seller_product_store')
        ->name('seller.product.store')->middleware('demo');
    // Vendor product update
    Route::post('product/upload/update', 'backend\seller\products\ProductController@seller_product_update')
        ->name('seller.product.update')->middleware('demo');
    /*vendor product list*/
    Route::get('products', 'backend\seller\products\ProductController@index')->name('seller.products');
    Route::get('/product/delete/{id}', 'backend\seller\products\ProductController@destroy')->name('seller.products.destroy');
    Route::get('/product/edit/{id}', 'backend\seller\products\ProductController@edit')->name('seller.products.edit');
    Route::post('/product/update', 'backend\seller\products\ProductController@update')->name('seller.products.update')->middleware('demo');
    Route::get('/product/request', 'backend\seller\products\ProductController@request')->name('seller.product.request');
    Route::get('/product/published', 'backend\seller\products\ProductController@published')->name('seller.product.published');
    Route::post('/product/request/Store', 'backend\seller\products\ProductController@requestStore')->name('seller.product.request.store')->middleware('demo');

    /* vendor variation request */
    Route::get('/variation/request', 'backend\admin\products\VariantController@request_create')->name('seller.variation.request.create');
    Route::post('/variation/request/store', 'backend\admin\products\VariantController@request_store')->name('seller.variation.request.store')->middleware('demo');

    /*vendor product show*/
    Route::get('product/child/product/index', 'backend\seller\products\ProductController@productIndex')->name('admin.product.index');  //api ajax
    Route::get('product/child/product/show', 'backend\seller\products\ProductController@productShow')->name('admin.product.show');  //api ajax


    Route::get('category/request', 'backend\seller\products\CategoryController@catCreate')->name('seller.categories.create');
    Route::post('category/request/store', 'backend\seller\products\CategoryController@catStore')->name('seller.categories.store')->middleware('demo');

    /*earning*/
    Route::get('earning', 'backend\seller\EarningController@index')->name('seller.earning.index');

    //payment
    Route::get('payments/index', 'backend\seller\PaymentController@index')->name('payments.index');
    Route::get('payments/create', 'backend\seller\PaymentController@create')->name('payments.create');
    Route::post('payments/store', 'backend\seller\PaymentController@store')->name('payments.store')->middleware('demo');
    Route::get('payments/destroy/{id}', 'backend\seller\PaymentController@destroy')->name('payments.destroy');


    //account setup
    Route::get('account/setup', 'backend\seller\PaymentController@accountSetup')->name('account.create');
    Route::post('account/update', 'backend\seller\PaymentController@accountUpdate')->name('account.update')->middleware('demo');


});
