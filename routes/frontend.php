<?php

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('shipping/division/area', 'backend\shipping\ShippingController@get_division_area')->name('get.division.area'); //api ajax

Route::group(['middleware' => ['installed']], function () {

    //todo::custom verify user
    Route::get('user/verify/{token}', 'Auth\RegisterController@verifyUser')->name('user.verify');
    Route::post('send/verify/code', 'Auth\RegisterController@sendToken')->name('send.verify.token');
    Route::get('verify/user', 'Auth\RegisterController@verifyForm');
    if (vendorActive()) {

//        product.search
        Route::get('product/search','frontend\ProductController@searchProduct')->name('product.search');

        //checkout data
        Route::get('/checkout/get-data', 'frontend\guest\CheckoutController@indexAjaxVendor')->name('checkout.get.data'); //ajax api
        //Vendor Routes
        // Vendor register
        Route::get('/auth/seller/signup', 'VendorController@signup')->name('vendor.signup');

        // Vendor register store
        Route::post('/auth/seller/signup/store', 'VendorController@store')->name('vendor.store')->middleware('demo');
        Route::get('/auth/seller/success', 'VendorController@reg_success')->name('vendor.success');

        //seller shops
        Route::get('/seller/shops', 'VendorController@seller_shops')->name('vendor.shops');

        //seller shop
        Route::get('/seller/shop/{slug}', 'VendorController@seller_shop')->name('vendor.shop');

        // single product
        Route::get('/product/{sku}/{slug}', 'frontend\ProductController@single_product')->name('single.product');

        //Shop page
        Route::get('all/product', 'frontend\shop\ShopController@index')->name('all.product');

        //Category ways product
        Route::get('/category/{slug}', 'frontend\shop\ShopController@category_shop')->name('category.shop');

        //Brand wise product
        Route::get('/brand/{slug}', 'frontend\shop\ShopController@brand_shop')->name('brand.shop');
        Route::get('/product/get/vendor/variant/color', 'frontend\ProductController@variant_ways_seller')->name('product.variant.seller'); //ajax

        Route::get('/campaign/{slug}', 'frontend\campaign\CampaignsController@show')->name('customer.campaign.products');

        Route::get('product/variant/{vendor_id}/{vendor_product_id}/{campaign_id}', 'frontend\FrontendController@variantPro')->name('product.with.variant');


        /*place order*/
        Route::post('/place/order', 'frontend\order\OrderController@store')->name('place.order')->middleware('demo');
        Route::get('/place/order/success', 'frontend\order\OrderController@success')->name('order.success');

        Route::group(['middleware' => 'auth'], function () {
            Route::post('/add-to-cart', 'frontend\customer\CartsController@store')->name('add.to.cart'); //ajax
            //cart routes
            Route::get('/cart-list', 'frontend\customer\CartsController@index')->name('cart.list'); //ajax

            Route::post('/remove-from-cart', 'frontend\customer\CartsController@destroy')->name('remove.from.cart'); //ajax

            Route::get('/cart-update', 'frontend\customer\CartsController@update')->name('update.to.cart'); //ajax

            Route::get('/shopping-cart', 'frontend\customer\CartsController@shopping_cart')->name('shopping.cart');

            Route::get('/checkout', 'frontend\customer\CheckoutController@index')->name('checkout.index');

            /*Order Details & History*/
            Route::get('/your/orders', 'frontend\order\OrderController@your_orders')->name('customer.orders');
            Route::get('/order/details/{order_number}', 'frontend\order\OrderController@order_details')->name('customer.order_details');

            /*Track Order*/
            Route::get('/track/order', 'frontend\order\OrderController@track_order')->name('customer.track.order');
            Route::get('/track/order/number', 'frontend\order\OrderController@track_order_number')->name('customer.track.order.number'); // API Ajax
            Route::get('/tracking/order/{code}', 'frontend\order\OrderController@tracking_order_number')->name('customer.tracking.order.number');

            /*review product*/
            Route::get('/make/product/review/{code}', 'frontend\review\ReviewController@index')->name('customer.product.review');
            Route::post('/store/product/review/{code}', 'frontend\review\ReviewController@store')->name('customer.product.review.store')->middleware('demo');
        });
        //guest checkout vendor
        //cart routes
        Route::get('/guest/cart-list', 'frontend\guest\CartsController@index')->name('guest.cart.list'); //ajax
        Route::post('/guest/remove-from-cart', 'frontend\guest\CartsController@destroy')->name('guest.remove.from.cart'); //ajax
        Route::get('/guest/cart-update', 'frontend\guest\CartsController@update')->name('guest.update.to.cart'); //ajax

        if (guestCheckout()) {
            //checkout
            Route::get('/guest/checkout', 'frontend\guest\CheckoutController@index')->name('guest.checkout.index');
        }
        Route::get('/guest/shopping-cart', 'frontend\guest\CartsController@shopping_cart')->name('guest.shopping.cart');

    } else {

        //        product.search
        Route::get('product/search','ecommerce\ProductController@searchProduct')->name('product.search');
        //checkout data
        Route::get('/checkout/get-data', 'frontend\guest\CheckoutController@indexAjaxEcommerce')->name('checkout.get.data'); //ajax api
        Route::get('/product/{sku}/{slug}', 'ecommerce\ProductController@single_product')->name('single.product');

        Route::get('/brand/{slug}', 'frontend\shop\ShopController@brand_shop')->name('brand.shop');

        //Category wise product
        Route::get('/category/{slug}', 'ecommerce\ProductController@category_product')->name('category.shop');

        //Shop page
        Route::get('/products', 'ecommerce\ProductController@allProduct')->name('all.product');

        Route::get('ecommerce/product/variant', 'ecommerce\ProductController@variantWaysProduct')->name('ecommerce.product.variant'); //ajax

        Route::get('/campaign/{slug}', 'ecommerce\ProductController@show_campaign_product')->name('customer.campaign.products');

        Route::get('product/variant/{product_id}/{campaign_id}', 'ecommerce\ProductController@variantPro')->name('product.with.variant');

        /*place order*/
        Route::post('/place/order', 'ecommerce\OrderController@store')->name('place.order')->middleware('demo');
        Route::get('/place/order/success', 'ecommerce\OrderController@success')->name('order.success');

        Route::group(['middleware' => 'auth'], function () {
            Route::post('/add-to-cart', 'ecommerce\CartController@store')->name('add.to.cart'); //ajax
            //cart routes
            Route::get('/cart-list', 'ecommerce\CartController@index')->name('cart.list'); //ajax

            Route::post('/remove-from-cart', 'ecommerce\CartController@destroy')->name('remove.from.cart'); //ajax

            Route::get('/cart-update', 'ecommerce\CartController@update')->name('update.to.cart'); //ajax

            Route::get('/shopping-cart', 'ecommerce\CartController@shopping_cart')->name('shopping.cart');

            Route::get('/checkout', 'ecommerce\CartController@checkout')->name('checkout.index');

            /*Order Details & History*/
            Route::get('/your/orders', 'ecommerce\OrderController@your_orders')->name('customer.orders');
            Route::get('/order/details/{order_number}', 'ecommerce\OrderController@order_details')->name('customer.order_details');

            /*Track Order*/
            Route::get('/track/order', 'ecommerce\OrderController@track_order')->name('customer.track.order');
            Route::get('/track/order/number', 'ecommerce\OrderController@track_order_number')->name('customer.track.order.number'); // API Ajax
            Route::get('/tracking/order/{code}', 'ecommerce\OrderController@tracking_order_number')->name('customer.tracking.order.number');

            /*Review product*/
            Route::get('/make/product/review/{code}', 'ecommerce\ReviewController@index')->name('customer.product.review');
            Route::post('/store/product/review/{code}', 'ecommerce\ReviewController@store')->name('customer.product.review.store')->middleware('demo');
        });

        //guest checkout ecommerce
        //cart routes
        Route::get('/guest/cart-list', 'ecommerce\guest\CartsController@index')->name('guest.cart.list'); //ajax
        Route::post('/guest/remove-from-cart', 'ecommerce\guest\CartsController@destroy')->name('guest.remove.from.cart'); //ajax
        Route::get('/guest/cart-update', 'ecommerce\guest\CartsController@update')->name('guest.update.to.cart'); //ajax
        if (guestCheckout()) {
            //checkout
            Route::get('/guest/checkout', 'frontend\guest\CheckoutController@index')->name('guest.checkout.index');
        }
        Route::get('/guest/shopping-cart', 'ecommerce\guest\CartsController@shopping_cart')->name('guest.shopping.cart');

    }

    /*there are common routs*/
    Route::get('/quick/view/{slug}', 'frontend\ProductController@quick_view')->name('quick.view');

    Route::get('/brands', 'frontend\FrontendController@brands')->name('brands');

    // Social login
    Route::get('/auth/redirect/{provider}', 'SocialController@redirect')->name('google');
    Route::get('/callback/{provider}', 'SocialController@callback')->name('google.callback');

    Route::get('credential/check', 'frontend\FrontendController@loginCheck')->name('credential.check');


    /*currency change*/
    Route::post('currency/change', 'frontend\FrontendController@currencyChange')->name('frontend.currencies.change')->middleware('demo');
    Route::post('lang/change', 'frontend\FrontendController@languagesChange')->name('frontend.language.change')->middleware('demo');

    Route::get('/', 'frontend\FrontendController@index')->name('homepage');

    //comparison routes
    Route::get('/comparison', 'frontend\customer\ComparisonController@indexBlade')->name('comparison.index');
    Route::post('/comparison_items', 'frontend\customer\ComparisonController@index')->name('compare.list'); //ajax


    //campaigns routes
    Route::get('/campaigns', 'frontend\campaign\CampaignsController@index')->name('customer.campaigns.index');

    /*page routes*/
    Route::get('page/{slug}', 'frontend\FrontendController@page')->name('frontend.page');

    Route::get('redirect/login', function (\Illuminate\Http\Request $request) {
        Session::put('url.intended', $request->url);
        return redirect()->route('login');
    })->name('login-redirect');


    //checkout logistics
    Route::get('/get/logistics', 'frontend\customer\CheckoutController@get_logistics')->name('checkout.get.logistics'); //ajax api

    //checkout total amount
    Route::get('/get/total/amount', 'frontend\customer\CheckoutController@get_total_amount')->name('checkout.get.total.amount'); //ajax api



    //coupon routes
    Route::post('/coupon', 'frontend\customer\CheckoutController@coupon_store')->name('checkout.coupon.store')->middleware('demo');
    Route::post('/coupon/destroy', 'frontend\customer\CheckoutController@coupon_destroy')->name('checkout.coupon.destroy')->middleware('demo');

    /*paypal payment*/
    Route::post('paypal/payment', 'PaymentsController@paypalPayment')->name('paypal.payment')->middleware('demo');

    //stripe routes
    Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post')->middleware('demo');


    //wishlist routes
    Route::get('/wishlist', 'frontend\customer\WishlistsController@indexBlade')->name('wishlists.index');
    Route::get('/wishlist-items', 'frontend\customer\WishlistsController@index')->name('wishlists'); //ajax
    Route::post('/add-to-wishlist', 'frontend\customer\WishlistsController@store')->name('add.to.wishlist'); //ajax
    Route::post('/remove-from-wishlist', 'frontend\customer\WishlistsController@destroy')->name('remove.from.wishlist'); //ajax
    Route::get('/delete-from-wishlist/{slug}', 'frontend\customer\WishlistsController@delete')->name('delete.from.wishlist');

    Route::group(['middleware' => 'auth'], function () {
        // Customer routes
        //customer registration and profile
        Route::get('/profile', 'frontend\customer\CustomersController@index')->name('customer.index');
        Route::post('/profile/update', 'frontend\customer\CustomersController@update')->name('customer.update')->middleware('demo');

        /*COMPLAIN*/
        Route::get('/make/complain/{code}', 'frontend\complain\ComplainController@index')->name('customer.complain.index');
        Route::post('/store/complain', 'frontend\complain\ComplainController@store')->name('customer.complain.store')->middleware('demo');
        Route::get('/review/complain/{code}', 'frontend\complain\ComplainController@review')->name('customer.complain.review');


    });

    /*FILTER*/
    Route::get('/filter', 'frontend\shop\ShopController@filter')->name('shop.filter');

    Route::get('/header/search', 'frontend\shop\ShopController@search_header')->name('header.search');

});