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

use Illuminate\Support\Facades\Auth;

Route::get('x', function () {
    return formatPrice(100);
});

/*for install route*/

Route::group(['middleware' => 'install.check', 'prefix' => 'install'], function () {
    Route::get('/', 'InstallerController@welcome')->name('install');
    Route::get('permission', 'InstallerController@permission')->name('permission');
    Route::get('database', 'InstallerController@create')->name('create');
    Route::post('setup/database', 'InstallerController@dbStore')->name('db.setup')->middleware('demo');
    Route::get('check/database', 'InstallerController@checkDbConnection')->name('check.db');
    Route::get('setup/import/sql', 'InstallerController@importSql')->name('sql.setup');
    /*app active*/
    Route::post('app/active/store', 'InstallerController@activeAppStore')->name('app.active,store')->middleware('demo');
    Route::get('setup/create', 'InstallerController@sqlUpload')->name('org.create');
    Route::get('setup/create/demo', 'InstallerController@sqlUploadDemo')->name('org.create.demo');
    Route::post('setup/store', 'InstallerController@orgSetup')->name('org.setup')->middleware('demo');
    Route::get('setup/admin', 'InstallerController@adminCreate')->name('admin.create');
    Route::post('setup/admin/store', 'InstallerController@adminStore')->name('admin.store')->middleware('demo');

    /*vendor create*/
    Route::post('setup/vendor', 'InstallerController@vendor_store')->name('installer.vendor.store')->middleware('demo');
});


Route::group(['middleware' => 'installed'], function () {
    Auth::routes(['verify' => false]);
});


/*this is for redirect to prefix*/
Route::get('/home', function () {
    $user = Auth::user();
    try {
        /*this is for customer redirect*/
        $group_id = $user->groups[0]->pivot->group_id;
        $user_id = $user->groups[0]->pivot->user_id;
        if ($user->id == $user_id && $group_id == 2) {
            return redirect()->route('homepage');
        }
        if ($user->id == $user_id && $group_id == 5) {
            return redirect()->route('deliver.dashboard');
        }

        if (!vendorActive()) {
            return redirect()->route('dashboard');
        } else {

            /*this is for seller redirect*/
            $group_id = $user->groups[0]->pivot->group_id;
            $user_id = $user->groups[0]->pivot->user_id;
            if ($user->id == $user_id && $group_id == 3) {
                return redirect()->route('seller.dashboard');
            }

            /*this is for admin redirect*/
            return redirect()->route('dashboard');
        }
    } catch (Exception $exception) {
        return redirect()->route('homepage');
    }


})->name('home')->middleware('auth');
Auth::routes();
Route::group(['middleware' => ['auth', 'installed'], 'prefix' => 'dashboard'], function () {
//there are the user Manager section


    Route::get('home', 'HomeController@index')->name('dashboard')
        ->middleware('permissions:dashboard');
    Route::get('user/profile/edit', 'CommonController@userEdit')->name('users.edit')->middleware('permissions:dashboard');
    Route::post('user/update', 'CommonController@userUpdate')->name('users.update')->middleware('permissions:dashboard')->middleware('demo');

    Route::group(['middleware' => 'permissions:user-management'], function () {
        Route::group(['middleware' => 'permissions:user-setup'], function () {
            Route::get('user/create', 'CommonController@userCreate')->name('users.create');
            Route::get('user/destroy/{id}', 'CommonController@userDestroy')->name('users.destroy');
            Route::post('user/store', 'CommonController@userStore')->name('users.store')->middleware('demo');

            Route::get('user/profile/{id}', 'CommonController@userShow')->name('users.show');
            Route::get('user', 'CommonController@userIndex')->name('users.index');
            Route::get('user/banned/{id}', 'CommonController@userBanned')->name('users.banned');
            Route::get('user/modify/{id}', 'CommonController@userModify')->name('users.modify');
            Route::post('user/modify/update', 'CommonController@userModifyUpdate')->name('users.update.modify')->middleware('demo');
        });


        //permission mast be remove this
//        Route::group(['middleware'=>'rumon'],function (){ TODO::mast be remove commenting
        Route::get('permission/destroy/{id}', 'CommonController@permissionDestroy')->name('permissions.destroy');
        Route::get('permission/create', 'CommonController@permissionCreate')->name('permissions.create');
        Route::post('permission/store', 'CommonController@permissionStore')->name('permissions.store')->middleware('demo');
        Route::get('permission/edit/{id}', 'CommonController@permissionEdit')->name('permissions.edit');
        Route::post('permission/update', 'CommonController@permissionUpdate')->name('permissions.update')->middleware('demo');
        Route::get('permission/show/{id}', 'CommonController@permissionShow')->name('permissions.show');
        Route::get('permission', 'CommonController@permissionIndex')->name('permissions.index');
//        });

        //group
        Route::group(['middleware' => 'permissions:group-setup'], function () {
            Route::get('group/destroy/{id}', 'CommonController@groupDestroy')->name('groups.destroy');
            Route::get('group/create', 'CommonController@groupCreate')->name('groups.create');
            Route::post('group/store', 'CommonController@groupStore')->name('groups.store')->middleware('demo');
            Route::get('group/edit/{id}', 'CommonController@groupEdit')->name('groups.edit');
            Route::post('group/update', 'CommonController@groupUpdate')->name('groups.update')->middleware('demo');
            Route::get('group/show/{id}', 'CommonController@groupShow')->name('groups.show');
            Route::get('group', 'CommonController@groupIndex')->name('groups.index');
        });


        //module
        Route::group(['middleware' => 'permissions:permissions-manage'], function () {
            Route::get('module/index', 'CommonController@moduleIndex')->name('modules.index');
            Route::post('module/store', 'CommonController@moduleStore')->name('modules.store')->middleware('demo');
            Route::get('module/destroy/{id}', 'CommonController@moduleDestroy')->name('modules.destroy');
            Route::get('module/edit/{id}', 'CommonController@moduleEdit')->name('modules.edit');
            Route::post('module/update', 'CommonController@moduleUpdate')->name('modules.update')->middleware('demo');
        });
    });


//SMTP Setting
    Route::get('smtp', 'CommonController@smtpCreate')->name('smtp.create')->middleware('permissions:mail-setup');
    Route::post('smtp/store', 'CommonController@smtpStore')->name('smtp.store')->middleware('permissions:mail-setup')->middleware('demo');
//
//site setting
    Route::get('org-setting', 'CommonController@siteSetting')->name('site.setting')->middleware('permissions:site-setting');
    Route::post('setting/update', 'CommonController@siteSettingUpdate')->name('site.update')->middleware('permissions:site-setting')->middleware('demo');

    //site setting
    Route::get('socialite-setting', 'CommonController@socialiteCreate')->name('socialite.env.setting');//->middleware('permissions:site-setting');
    Route::post('socialite-setting/update', 'CommonController@socialiteStore')->name('socialite.env.store')->middleware('demo');//->middleware('permissions:site-setting');


//Language Setting
    Route::group(['middleware' => 'permissions:language-setup'], function () {
        Route::get('language', 'CommonController@langIndex')->name('language.index');
        Route::post('language/store', 'CommonController@langStore')->name('language.store')->middleware('demo');
        Route::get('language/destroy/{id}', 'CommonController@langDestroy')->name('language.destroy');
        Route::get('language/translate/{id}', 'CommonController@translate_create')->name('language.translate');
        Route::post('language/translate/store', 'CommonController@translate_store')->name('language.translate.store')->middleware('demo');
        Route::get('language/default/{id}', 'CommonController@defaultLanguage')->name('language.default');
    });

    Route::post('language/change', 'CommonController@languagesChange')->name('language.change')->middleware('demo');

//Currency Setting
    Route::group(['middleware' => 'permissions:currency-setup'], function () {
        Route::get('currency', 'CommonController@currencyIndex')->name('currencies.index');
        Route::get('currency/create', 'CommonController@currencyCreate')->name('currencies.create');
        Route::post('currency/store', 'CommonController@currencyStore')->name('currencies.store')->middleware('demo');
        Route::get('currency/delete/{id}', 'CommonController@currencyDestroy')->name('currencies.destroy');
        Route::get('currency/edit/{id}', 'CommonController@currencyEdit')->name('currencies.edit');
        Route::post('currency/update', 'CommonController@currencyUpdate')->name('currencies.update')->middleware('demo');
        Route::post('currency/default', 'CommonController@currencyDefault')->name('currencies.default')->middleware('demo');
        Route::get('currency/published', 'CommonController@currencyPublished')->name('currencies.published');
        Route::get('currency/align', 'CommonController@currencyAlignment')->name('currencies.align');
    });

    Route::post('currency/change', 'CommonController@currenciesChange')->name('currencies.change');

//all pages
    Route::group(['middleware' => 'permissions:pages-manage'], function () {
        Route::get('page/group/index', 'CommonController@pageGroupIndex')->name('pages.group.index');
        Route::post('page/group/store', 'CommonController@pageGroupStore')->name('pages.group.store')->middleware('demo');
        Route::post('page/group/update', 'CommonController@pageGroupUpdate')->name('pages.group.update')->middleware('demo');
        Route::get('page/group/edit/{id}', 'CommonController@pageGroupEdit')->name('pages.group.edit');
        Route::get('page/group/delete/{id}', 'CommonController@pageGroupDelete')->name('pages.group.destroy');
        Route::get('page/group/publish', 'CommonController@pageGroupPublish')->name('pages.group.publish');
        Route::get('pages', 'CommonController@pageIndex')->name('pages.index');
        Route::get('pages/create', 'CommonController@pageCreate')->name('pages.create');
        Route::get('pages/delete/{id}', 'CommonController@pageDestroy')->name('pages.destroy');
        Route::post('pages/store', 'CommonController@pageStore')->name('pages.store')->middleware('demo');
        Route::get('pages/edit/{id}', 'CommonController@pageEdit')->name('pages.edit');
        Route::post('pages/update', 'CommonController@pageUpdate')->name('pages.update')->middleware('demo');
        Route::get('pages/active', 'CommonController@pageActive')->name('pages.active');
        Route::get('content/{id}', 'CommonController@contentIndex')->name('pages.content.index');
        Route::get('pages/content/create/{id}', 'CommonController@contentCreate')->name('pages.content.create');
        Route::post('pages/content/store', 'CommonController@contentStore')->name('pages.content.store')->middleware('demo');
        Route::get('pages/content/active', 'CommonController@contentActive')->name('pages.content.active');
        Route::get('pages/content/edit/{id}', 'CommonController@contentEdit')->name('pages.content.edit');
        Route::post('pages/content/update', 'CommonController@contentUpdate')->name('pages.content.update')->middleware('demo');
        Route::get('pages/content/delete/{id}', 'CommonController@contentDestroy')->name('pages.content.destroy');

        /*info page*/
        Route::get('info/page/index', 'InfoPageController@index')->name('info.page.index');
        Route::get('info/page/delete/{id}', 'InfoPageController@delete')->name('info.page.destroy');
        Route::get('info/page/edit/{id}', 'InfoPageController@edit')->name('info.page.edit');
        Route::post('info/page/store', 'InfoPageController@store')->name('info.page.store')->middleware('demo');
        Route::post('info/page/update', 'InfoPageController@update')->name('info.page.update')->middleware('demo');
    });

//Category
    Route::group(['middleware' => 'permissions:category-management'], function () {
        Route::get('category/index/{id}/{slug}', 'backend\admin\products\CategoryController@categoryIndex')->name('parent.categories.index');
        Route::get('category/parent/create/{id}/{slug}', 'backend\admin\products\CategoryController@parentCategoryCreate')->name('parent.categories.create');
        Route::get('category/parent/edit/{id}/{parentId}', 'backend\admin\products\CategoryController@parentCatEdit')->name('parent.categories.edit');
        Route::post('category/parent/store', 'backend\admin\products\CategoryController@parentCategoryStore')->name('parent.categories.store')->middleware('demo');
        Route::post('category/parent/update', 'backend\admin\products\CategoryController@parentCategoryUpdate')->name('parent.categories.update')->middleware('demo');
        Route::get('category/child/index/{id}/{slug}', 'backend\admin\products\CategoryController@childCategories')->name('child.categories.index');
        Route::get('category/create/{id}/{slug}', 'backend\admin\products\CategoryController@categoryCreate')->name('categories.create');
        Route::post('category/store', 'backend\admin\products\CategoryController@categoryStore')->name('categories.store')->middleware('demo');
        Route::get('category/edit/{id}/{slug}', 'backend\admin\products\CategoryController@categoryEdit')->name('categories.edit');
        Route::post('category/update', 'backend\admin\products\CategoryController@categoryUpdate')->name('categories.update')->middleware('demo');
        Route::get('category/destroy/{id}', 'backend\admin\products\CategoryController@categoryDestroy')->name('categories.destroy');
        /*group category route*/
        Route::get('category', 'backend\admin\products\CategoryController@catGroupIndex')->name('categories.index');
        Route::get('category/group/edit/{id}', 'backend\admin\products\CategoryController@catGroupEdit')->name('group.categories.edit');
        Route::get('category/group/create', 'backend\admin\products\CategoryController@catGroupCreate')->name('group.categories.create');
        Route::post('category/group/store', 'backend\admin\products\CategoryController@catGroupStore')->name('group.categories.store')->middleware('demo');
        Route::post('category/group/update', 'backend\admin\products\CategoryController@catGroupUpdate')->name('group.categories.update')->middleware('demo');

//this route for published or unpublished
        Route::get('category/published', 'backend\admin\products\CategoryController@categoryPublished')->name('categories.published');
        Route::get('category/popular', 'backend\admin\products\CategoryController@categoryPopular')->name('categories.popular');
        Route::get('category/top', 'backend\admin\products\CategoryController@categoryTop')->name('categories.top');
    });

    Route::group(['middleware' => 'permissions:brand-manage'], function () {
        Route::get('products/brands', 'backend\admin\products\BrandsController@index')->name('brands.index');
        Route::get('products/brands/create', 'backend\admin\products\BrandsController@create')->name('brands.create');
        Route::post('products/brands/store', 'backend\admin\products\BrandsController@store')->name('brands.store')->middleware('optimizeImages')->middleware('demo');
        Route::get('products/brands/edit/{id}', 'backend\admin\products\BrandsController@edit')->name('brands.edit');
        Route::post('products/brands/update', 'backend\admin\products\BrandsController@update')->name('brands.update')->middleware('demo');
        Route::get('products/brands/destroy/{id}', 'backend\admin\products\BrandsController@destroy')->name('brands.destroy');
        Route::get('products/brands/search-published', 'backend\admin\products\BrandsController@searchPublished')->name('brands.search.published');
        Route::get('products/brands/search-unpublished', 'backend\admin\products\BrandsController@searchUnpublished')->name('brands.search.unpublished');
        Route::get('products/brands/approve/{id}', 'backend\admin\products\BrandsController@approve')->name('brands.approve');
        Route::get('products/brands/published', 'backend\admin\products\BrandsController@brandPublished')->name('brands.published');
    });

    /*commission routes*/
    Route::group(['middleware' => 'permissions:commission-management'], function () {
        Route::get('commission', 'backend\admin\products\CommissionController@index')->name('commissions.index');
        Route::post('commission/store', 'backend\admin\products\CommissionController@store')->name('commissions.store')->middleware('demo');
        Route::get('commission/edit/{id}', 'backend\admin\products\CommissionController@edit')->name('commissions.edit');
        Route::post('commission/update', 'backend\admin\products\CommissionController@update')->name('commissions.update')->middleware('demo');
        Route::get('commission/delete/{id}', 'backend\admin\products\CommissionController@destroy')->name('commissions.destroy');
    });

    /*section setting*/

    Route::get('section/setting', 'backend\settings\SectionSettingController@index')->name('section.setting.index');
    Route::get('section/setting/sort', 'backend\settings\SectionSettingController@sectionSort')->name('section.setting.sort');
    Route::get('section/setting/status', 'backend\settings\SectionSettingController@sectionStatus')->name('section.setting.status');


    /*business setting*/

    Route::get('business/system-settings/index', 'backend\settings\SectionSettingController@businessSettings')->name('business.setting.index');
    Route::post('business/setting/store', 'backend\settings\SectionSettingController@businessSettingsStore')->name('business.setting.store')->middleware('demo');


    /*product variant*/
    Route::group(['middleware' => 'permissions:product-variant-manage'], function () {
        Route::get('variant/index', 'backend\admin\products\VariantController@index')->name('variants.index');
        Route::post('variant/store', 'backend\admin\products\VariantController@store')->name('variants.store')->middleware('demo');
        Route::get('variant/edit/{id}', 'backend\admin\products\VariantController@edit')->name('variants.edit');
        Route::post('variant/update', 'backend\admin\products\VariantController@update')->name('variants.update')->middleware('demo');
        Route::get('variant/destroy/{id}', 'backend\admin\products\VariantController@destroy')->name('variants.destroy');

        /** variation request */
        Route::get('product/variation/approve/{id}', 'backend\admin\products\VariantController@variation_approve')->name('admin.variation.approve');
        Route::get('product/variation/decline/{id}', 'backend\admin\products\VariantController@variation_decline')->name('admin.variation.decline');
        Route::get('product/variation/edit/{id}', 'backend\admin\products\VariantController@variation_request_edit')->name('admin.variation.edit');
        Route::post('product/variation/update/{id}', 'backend\admin\products\VariantController@variation_request_update')->name('admin.variation.update')->middleware('demo');
    });

    /*admin product create*/
    Route::get('product/child/index', 'backend\admin\products\ProductController@childIndex')->name('admin.child.index');  //api ajax
    Route::get('product/remove/image/{id}', 'backend\admin\products\ProductController@removeImage')->name('admin.products.image.remove'); //api ajax
    Route::group(['middleware' => 'permissions:product-manage'], function () {
        Route::get('product/create', 'backend\admin\products\ProductController@create')->name('admin.products.create');
        Route::post('product/store', 'backend\admin\products\ProductController@store')->name('admin.products.store')->middleware('optimizeImages')->middleware('demo');
        Route::get('product/index', 'backend\admin\products\ProductController@index')->name('admin.products.index');
        Route::get('request/product/index', 'backend\admin\products\ProductController@requestIndex')->name('admin.request.products.index');
        Route::get('product/edit/{id}/{slug}', 'backend\admin\products\ProductController@edit')->name('admin.products.edit');
        Route::get('product/active/{id}/{slug}', 'backend\admin\products\ProductController@active')->name('admin.products.active');
        Route::post('product/update', 'backend\admin\products\ProductController@update')->name('admin.products.update')->middleware('optimizeImages')->middleware('demo');
        Route::get('product/destroy/{id}', 'backend\admin\products\ProductController@destroy')->name('admin.products.destroy');
        Route::get('product/published', 'backend\admin\products\ProductController@published')->name('admin.product.published');
    });


    //campaigns
    Route::group(['middleware' => 'permissions:campaign-manage'], function () {
        Route::get('campaigns', 'backend\admin\campaign\CampaignsController@index')->name('admin.campaign.index');
        Route::get('campaigns/create', 'backend\admin\campaign\CampaignsController@create')->name('admin.campaign.create');
        Route::post('campaigns/store', 'backend\admin\campaign\CampaignsController@store')->name('admin.campaign.store')->middleware('optimizeImages')->middleware('demo');
        Route::get('campaigns/edit/{id}', 'backend\admin\campaign\CampaignsController@edit')->name('admin.campaign.edit');
        Route::post('campaigns/update', 'backend\admin\campaign\CampaignsController@update')->name('admin.campaign.update')->middleware('demo');
        Route::get('campaigns/re-campaign/{id}', 'backend\admin\campaign\CampaignsController@reCampaignEdit')->name('admin.campaign.reCampaignEdit');
        Route::post('campaigns/re-campaign', 'backend\admin\campaign\CampaignsController@reCampaignStore')->name('admin.campaign.reCampaignStore')->middleware('demo');
        Route::get('campaigns/search', 'backend\admin\campaign\CampaignsController@search')->name('admin.campaign.search');
        Route::get('campaigns/seller-published', 'backend\admin\campaign\CampaignsController@sellerPublished')->name('admin.campaign.sellerPublished');
        Route::get('campaigns/customerPublished', 'backend\admin\campaign\CampaignsController@customerPublished')->name('admin.campaign.customerPublished');
        Route::get('campaigns/destroy/{id}', 'backend\admin\campaign\CampaignsController@destroy')->name('admin.campaign.destroy');
        Route::get('campaign/products/{slug}', 'backend\admin\campaign\CampaignsController@indexProducts')->name('admin.campaign.products');
        Route::post('campaigns/add-products', 'backend\admin\campaign\CampaignsController@productStore')->name('admin.campaign.products.store'); //ajax
        Route::post('campaigns/remove-product', 'backend\admin\campaign\CampaignsController@productDestroy')->name('admin.campaign.products.destroy'); //ajax
        Route::get('campaigns/product-search', 'backend\admin\campaign\CampaignsController@searchProducts')->name('admin.campaign.products.search');
    });

    //payment method key to env
    Route::group(['middleware' => 'permissions:payment-method-setup'], function () {
        Route::get('payment/method', 'backend\settings\PaymentsController@index')->name('payment.method.index');
        Route::post('payment/method/store', 'backend\settings\PaymentsController@store')->name('payment.method.store')->middleware('demo');
        Route::post('payment/logo/store', 'backend\settings\PaymentsController@logoStore')->name('payment.logo.store')->middleware('demo');
    });


    //code by prince
    //Promotions
    Route::group(['middleware' => 'permissions:promotions-banner-setup'], function () {
        Route::get('promotions/category', 'backend\admin\promotions\PromotionController@categoryPromotion')->name('category.promotion');
        Route::post('promotions/category/store', 'backend\admin\promotions\PromotionController@categoryPromotionStore')->name('category.promotion.store')->middleware('demo');
        Route::get('/promotions/category/edit/{id}', 'backend\admin\promotions\PromotionController@categoryPromotionEdit')->name('category.promotion.edit');
        Route::post('/promotions/category/update/{id}', 'backend\admin\promotions\PromotionController@categoryPromotionUpdate')->name('category.promotion.update')->middleware('demo');
        // Activation
        Route::post('/promotions/activation', 'backend\admin\promotions\PromotionController@promotion_activation')->name('promotion.activation')->middleware('demo');
        // Delete
        Route::get('/promotions/delete/{id}', 'backend\admin\promotions\PromotionController@PromotionDelete')->name('promotions.destroy');

        // Main Slider
        Route::get('promotions/main/slider', 'backend\admin\promotions\PromotionController@main_slider')->name('main.slider.promotion');
        Route::post('promotions/main/slider/store', 'backend\admin\promotions\PromotionController@main_slider_store')->name('main.slider.promotion.store')->middleware('demo');
        Route::get('/promotions/main/slider/edit/{id}', 'backend\admin\promotions\PromotionController@main_slider_edit')->name('main.slider.edit');
        Route::post('/promotions/main/slider/update/{id}', 'backend\admin\promotions\PromotionController@main_slider_update')->name('main.slider.update')->middleware('demo');

        // section banner
        Route::get('/promotions/section/banner', 'backend\admin\promotions\PromotionController@section_banner')->name('section.promotion');
        Route::post('/promotions/section/banner/store', 'backend\admin\promotions\PromotionController@section_banner_store')->name('section.promotion.store')->middleware('demo');
        Route::get('/promotions/section/banner/edit/{id}', 'backend\admin\promotions\PromotionController@section_banner_edit')->name('section.promotion.edit');
        Route::post('/promotions/section/banner/update/{id}', 'backend\admin\promotions\PromotionController@section_banner_update')->name('section.promotion.update')->middleware('demo');

        // section banner
        Route::get('/promotions/header', 'backend\admin\promotions\PromotionController@header_banner')->name('header.promotion');
        Route::post('/promotions/header/store', 'backend\admin\promotions\PromotionController@header_banner_store')->name('header.promotion.store')->middleware('demo');
        Route::get('/promotions/header/edit/{id}', 'backend\admin\promotions\PromotionController@header_banner_edit')->name('header.promotion.edit');
        Route::post('/promotions/header/update/{id}', 'backend\admin\promotions\PromotionController@header_banner_update')->name('header.promotion.update')->middleware('demo');

        // POP UP
        Route::get('/promotions/popup', 'backend\admin\promotions\PromotionController@popup')->name('popup.promotion');
        Route::post('/promotions/popup/store', 'backend\admin\promotions\PromotionController@popup_store')->name('popup.promotion.store')->middleware('demo');
        Route::get('/promotions/popup/edit/{id}', 'backend\admin\promotions\PromotionController@popup_edit')->name('popup.promotion.edit');
        Route::post('/promotions/popup/update/{id}', 'backend\admin\promotions\PromotionController@popup_update')->name('popup.promotion.update')->middleware('demo');

    });


    // shipping Method
    Route::group(['middleware' => 'permissions:shipping-setup'], function () {
        Route::get('shipping/zone', 'backend\shipping\ShippingController@shipping_zone')->name('shipping.zone');
        Route::post('shipping/zone/create', 'backend\shipping\ShippingController@shipping_zone_create')->name('shipping.zone.create')->middleware('demo');
        Route::post('shipping/zone/division/create', 'backend\shipping\ShippingController@shipping_zone_division_create')->name('shipping.zone.division.create')->middleware('demo');

        Route::get('shipping/logistics', 'backend\shipping\ShippingController@logistics')->name('logistics');
        Route::post('shipping/logistics/activation', 'backend\shipping\ShippingController@logistic_activation')->name('logistic.activation'); //api ajax
        Route::post('shipping/logistic/store', 'backend\shipping\ShippingController@logistic_store')->name('logistic.store')->middleware('demo');
        Route::post('shipping/logistic/area/store', 'backend\shipping\ShippingController@logistic_area_store')->name('logistics.area.store')->middleware('demo');
        Route::get('shipping/logistic/area/edit/{id}', 'backend\shipping\ShippingController@logistic_area_edit')->name('logistics.area.edit');
        Route::post('shipping/logistic/area/update/{id}', 'backend\shipping\ShippingController@logistic_area_update')->name('logistics.area.update')->middleware('demo');
        Route::get('shipping/logistic/area/delete/{id}', 'backend\shipping\ShippingController@logistic_area_delete')->name('logistics.area.destroy');
        Route::get('shipping/logistic/delete/{id}', 'backend\shipping\ShippingController@logistic_delete')->name('logistics.destroy');
        Route::get('shipping/logistic/area/activation', 'backend\shipping\ShippingController@logistic_area_activation')->name('logistic.area.activation'); //api ajax

    });

    //Coupon
    Route::group(['middleware' => 'permissions:coupon-setup'], function () {
        Route::get('coupon', 'backend\coupon\CouponController@index')->name('coupon');
        Route::post('coupon/store', 'backend\coupon\CouponController@store')->name('coupon.store')->middleware('demo');
        Route::get('coupon/edit/{id}', 'backend\coupon\CouponController@edit')->name('coupon.edit');
        Route::post('coupon/update/{id}', 'backend\coupon\CouponController@update')->name('coupon.update')->middleware('demo');
        Route::post('coupon/activation', 'backend\coupon\CouponController@coupon_activation')->name('coupon.activation'); //api ajax
    });


    /*earning*/
    Route::get('/earning', 'backend\admin\EarningController@index')->name('earning.index')
        ->middleware('permissions:admin-earning');

    Route::group(['middleware' => 'permissions:seller-management'], function () {
        Route::get('create', 'VendorController@create')
            ->name('vendor.create');
        Route::post('vendor/store', 'VendorController@vendor_store')
            ->name('manual.vendor.store')->middleware('demo');
        Route::get('requests', 'VendorController@requests')
            ->name('vendor.requests');
        Route::get('requests/view/{id}', 'VendorController@requests_view')
            ->name('vendor.requests.view');

        Route::post('request/accept/{id}', 'VendorController@accept')
            ->name('vendor.requests.accept')->middleware('demo');

        Route::get('seller/view/{id}', 'VendorController@requests_view2')
            ->name('vendor.requests.view2');
        Route::get('all', 'VendorController@all_seller')
            ->name('vendor.all');
        Route::get('vendor/banned/{id}', 'VendorController@vendorBanned')->name('vendor.banned');
    });


    Route::group(['middleware' => 'permissions:seller-management', 'middleware' => 'permissions:seller'], function () {
        Route::get('profile', 'VendorController@profile')
            ->name('vendor.profile');
        Route::post('profile/update', 'VendorController@seller_update')
            ->name('vendor.update')->middleware('demo');
    });


    /*this for vendor payment manage*/
    Route::group(['middleware' => 'permissions:seller-payment'], function () {
        Route::get('seller-payments', 'backend\admin\PaymentController@index')->name('admin.payments.index');
        Route::get('account/details/{id}/{userId}/{method}/{payId}', 'backend\admin\PaymentController@accountDetails')
            ->name('account.details');
        Route::get('payments/status/{id}', 'backend\admin\PaymentController@status')->name('payments.status');
    });

    /*this for vendor payment manage*/
    Route::group(['middleware' => 'permissions:addons-manager'], function () {
        Route::get('addons-manager', 'backend\admin\AddonsController@addons_manager')->name('addons.manager.index');
        Route::get('addon/installation', 'backend\admin\AddonsController@installui')->name('addons.manager.installui');
        Route::post('addon/install', 'backend\admin\AddonsController@index')->name('addons.install.index')->middleware('demo');
        Route::get('addon/status/{addon}', 'backend\admin\AddonsController@addon_status')->name('addon.status');
        Route::get('addon/preview/{addon}', 'backend\admin\AddonsController@addon_preview')->name('addon.preview');
        Route::get('addon/setup', 'backend\admin\AddonsController@addon_setup')->name('addon.setup');
        Route::get('addon/setup/{addon}', 'backend\admin\AddonsController@addon_setup')->name('addon.setup');
        Route::get('addons/purchase/code/verify/{addon}', 'backend\admin\AddonsController@purchase_code_verify')
            ->middleware('te-amo')->middleware('demo')
            ->name('addons.purchase_code.verify');

        //paytm setup
        Route::post('addons/paytm/account/setup', 'backend\admin\AddonsController@paytm_account_setup')->name('addons.paytm.account.setup')->middleware('demo');

        // ssl setup
        Route::post('addons/ssl/account/setup', 'backend\admin\AddonsController@ssl_commerz_account_setup')->name('addons.ssl.account.setup')->middleware('demo');

        //paytm setup

    });


    /*todo::there are all ecommerce setting note that there have only ecommerce route,*/
    Route::get('app/active', 'ecommerce\HomeController@appActive')->name('app.active')->middleware('permissions:app-active');

    if (!vendorActive()) {
        Route::get('product/step/tow/{id}/{slug}', 'ecommerce\HomeController@productStepTow')->name('product.step.tow');
        Route::post('product/step/tow', 'ecommerce\HomeController@productStepTowStore')->name('product.step.tow.store')->middleware('demo');
        Route::get('product/step/tow/edit/{id}/{slug}', 'ecommerce\HomeController@productStepTowEdit')->name('product.step.tow.edit');
        Route::post('product/step/tow/edit', 'ecommerce\HomeController@productStepTowUpdate')->name('product.step.tow.update')->middleware('demo');
        Route::get('product/child/product/show', 'backend\seller\products\ProductController@productShow')->name('admin.product.show'); //this is 2nd copy //ajax

        /**
         * Order Management
         */
        Route::group(['middleware' => 'permissions:order-manage'], function () {
            Route::get('/orders', 'ecommerce\AdminOrderController@index')->name('orders.index');


            // find order
            Route::get('/find/order', 'ecommerce\AdminOrderController@find_order')->name('find.order');
            Route::get('/filter/{type}', 'ecommerce\AdminOrderController@filter')->name('find.filter');
        });

        Route::group(['middleware' => 'permissions:order-manage'], function () {
            Route::get('/order/confirm/{id}', 'ecommerce\AdminOrderController@confirm')->name('order.confirm');
            Route::get('/order/cancel/{id}', 'ecommerce\AdminOrderController@cancel')->name('order.cancel');
            Route::get('/order/processing/{id}', 'ecommerce\AdminOrderController@processing')->name('order.processing');
            Route::get('/order/quality/check/{id}', 'ecommerce\AdminOrderController@quality_check')->name('order.quality_check');
            Route::get('/order/product/dispatched/{id}', 'ecommerce\AdminOrderController@product_dispatched')->name('order.product_dispatched');
            Route::get('/order/delivered/{id}', 'ecommerce\AdminOrderController@delivered')->name('order.delivered');
            Route::get('/order/followup/{id}', 'ecommerce\AdminOrderController@followup')->name('order.followup');
            Route::post('/order/followup/comment/{id}', 'ecommerce\AdminOrderController@followup_comment')->name('order.followup_comment')->middleware('demo');
        });

        if (deliverActive()) {
            Route::group(['middleware' => 'permissions:deliver'], function () {
                Route::get('/deliver/order/delivered/{id}', 'ecommerce\AdminOrderController@delivered')->name('deliver.order.delivered');
                Route::get('/deliver/order/followup/{id}', 'ecommerce\AdminOrderController@followup')->name('deliver.order.followup');
                Route::post('/deliver/order/followup/comment/{id}', 'ecommerce\AdminOrderController@followup_comment')->name('deliver.order.followup_comment')->middleware('demo');
            });
        }


        /**
         * FULLFILLMENT MANAGEMENT
         */
        Route::group(['middleware' => 'permissions:fullfill-manage'], function () {
            Route::get('/fullfillment/orders', 'ecommerce\FullfillmentController@index')->name('fullfillment.index');
            Route::get('/fullfillment/logistic/{logistic}', 'ecommerce\FullfillmentController@logistic')->name('fullfillment.logistic');
        });

        /**
         * COMPLAIN MANAGEMENT
         */
        Route::group(['middleware' => 'permissions:complain-manage'], function () {
            Route::get('/complains', 'ecommerce\ComplainController@index')->name('complains.index');
            Route::get('/complain/solved/{id}', 'ecommerce\ComplainController@solved')->name('complains.solved');
            Route::get('/complain/notsolved/{id}', 'ecommerce\ComplainController@notsolved')->name('complains.notsolved');
            Route::get('/complain/filter/{type}', 'ecommerce\ComplainController@filter')->name('complains.filter');
            Route::get('/find/complain', 'ecommerce\ComplainController@find_complain')->name('find.complain');
        });

    }
    else {

        /**
         * Order Management
         */
        Route::group(['middleware' => 'permissions:order-manage'], function () {
            Route::get('/orders', 'backend\order\OrderController@index')->name('orders.index');
            // find order
            Route::get('/find/order', 'backend\order\OrderController@find_order')->name('find.order');
            Route::get('/filter/{type}', 'backend\order\OrderController@filter')->name('find.filter');
        });

        Route::group(['middleware' => 'permissions:order-modify'], function () {
            Route::get('/order/confirm/{id}', 'backend\order\OrderController@confirm')->name('order.confirm');
            Route::get('/order/cancel/{id}', 'backend\order\OrderController@cancel')->name('order.cancel');
            Route::get('/order/processing/{id}', 'backend\order\OrderController@processing')->name('order.processing');
            Route::get('/order/quality/check/{id}', 'backend\order\OrderController@quality_check')->name('order.quality_check');
            Route::get('/order/product/dispatched/{id}', 'backend\order\OrderController@product_dispatched')->name('order.product_dispatched');
            Route::get('/order/delivered/{id}', 'backend\order\OrderController@delivered')->name('order.delivered');
            Route::get('/order/followup/{id}', 'backend\order\OrderController@followup')->name('order.followup');
            Route::post('/order/followup/comment/{id}', 'backend\order\OrderController@followup_comment')->name('order.followup_comment')->middleware('demo');

        });


        if (deliverActive()) {
            Route::group(['middleware' => 'permissions:deliver'], function () {
                Route::post('/deliver/order/followup/comment/{id}', 'backend\order\OrderController@followup_comment')->name('deliver.order.followup_comment')->middleware('demo');
                Route::get('/deliver/order/delivered/{id}', 'backend\order\OrderController@delivered')->name('deliver.order.delivered');
                Route::get('/deliver/order/followup/{id}', 'backend\order\OrderController@followup')->name('deliver.order.followup');
            });
        }



        /**
         * FULLFILLMENT MANAGEMENT
         */
        Route::group(['middleware' => 'permissions:fullfill-manage'], function () {
            Route::get('/fullfillment/orders', 'backend\order\FullfillmentController@index')->name('fullfillment.index');
            Route::get('/fullfillment/logistic/{logistic}', 'backend\order\FullfillmentController@logistic')->name('fullfillment.logistic');
        });

        /**
         * COMPLAIN MANAGEMENT
         */
        Route::group(['middleware' => 'permissions:complain-manage'], function () {
            Route::get('/complains', 'backend\complain\ComplainController@index')->name('complains.index');
            Route::get('/complain/solved/{id}', 'backend\complain\ComplainController@solved')->name('complains.solved');
            Route::get('/complain/notsolved/{id}', 'backend\complain\ComplainController@notsolved')->name('complains.notsolved');
            Route::get('/complain/filter/{type}', 'backend\complain\ComplainController@filter')->name('complains.filter');
            Route::get('/find/complain', 'backend\complain\ComplainController@find_complain')->name('find.complain');
        });
    }

});

