<?php


Route::group(['middleware' => ['auth', 'installed'], 'prefix' => 'dashboard'], function () {

    if (vendorActive()){
        /*deliver*/
        Route::get('deliver/pending', 'DeliverUserController@deliverDashboard')->name('deliver.dashboard');
        Route::get('deliver/delivered', 'DeliverUserController@orderDelivered')->name('deliver.delivered');

        /*pick the order*/
        Route::get('deliver/pick/{id}', 'DeliverUserController@deliverPick')->name('deliver.pick');
        /*pick with duration*/
        Route::post('deliver/pick', 'DeliverUserController@deliverPickStore')->name('deliver.pick.store');

        //order.location.status
        Route::get('deliver/order/status/{id}', 'DeliverUserController@locationStatus')->name('order.location.status');
        Route::post('deliver/order/status', 'DeliverUserController@locationStatusStore')->name('order.location.status.store');

        //deliver register from
        Route::get('deliver/request', 'DeliverUserController@deliverUserIndex')->name('deliver.request');
        Route::get('deliver/details/{id}', 'DeliverUserController@deliverUserDetails')->name('deliver.details.show');
        Route::post('deliver/confirm', 'DeliverUserController@deliverUserConfirm')->name('deliver.confirm');
        Route::get('deliver/about/{id}', 'DeliverUserController@deliverUserAbout')->name('deliver.about');
        Route::get('deliver/index', 'DeliverUserController@index')->name('deliver.index');
        Route::get('deliver/banned/{id}', 'DeliverUserController@banned')->name('deliver.banned');
        /*assign remove*/
        Route::get('deliver/assign/remove/{id}', 'DeliverUserController@deliverPickRemove')->name('deliver.assign.destroy');
        /*assign */
        Route::get('order/deliver/list', 'DeliverUserController@ordersList')->name('deliver.order.list');

        /*assign deliver get*/
        Route::get('deliver/assign/{id}', 'DeliverUserController@assignCreate')->name('deliver.assign');
        Route::post('deliver/assign', 'DeliverUserController@assignStore')->name('deliver.store');
        Route::get('deliver/assign/details/{id}', 'DeliverUserController@assignDetails')->name('deliver.assign.details');
        Route::get('deliver/orderDelivered', 'DeliverUserController@orderDelivered')->name('deliver.allDeliver');
    }else{
        /*deliver*/
        Route::get('deliver/pending', 'DeliverUserEcommerceController@deliverDashboard')->name('deliver.dashboard');
        Route::get('deliver/delivered', 'DeliverUserEcommerceController@orderDelivered')->name('deliver.delivered');

        /*pick the order*/
        Route::get('deliver/pick/{id}', 'DeliverUserEcommerceController@deliverPick')->name('deliver.pick');
        /*pick with duration*/
        Route::post('deliver/pick', 'DeliverUserEcommerceController@deliverPickStore')->name('deliver.pick.store');
        /*assign remove*/
        Route::get('deliver/assign/remove/{id}', 'DeliverUserEcommerceController@deliverPickRemove')->name('deliver.assign.destroy');

        //order.location.status
        Route::get('deliver/order/status/{id}', 'DeliverUserEcommerceController@locationStatus')->name('order.location.status');
        Route::post('deliver/order/status', 'DeliverUserEcommerceController@locationStatusStore')->name('order.location.status.store');

        //deliver register from
        Route::get('deliver/request', 'DeliverUserEcommerceController@deliverUserIndex')->name('deliver.request');
        Route::get('deliver/details/{id}', 'DeliverUserEcommerceController@deliverUserDetails')->name('deliver.details.show');
        Route::post('deliver/confirm', 'DeliverUserEcommerceController@deliverUserConfirm')->name('deliver.confirm');
        Route::get('deliver/about/{id}', 'DeliverUserEcommerceController@deliverUserAbout')->name('deliver.about');
        Route::get('deliver/index', 'DeliverUserEcommerceController@index')->name('deliver.index');
        Route::get('deliver/banned/{id}', 'DeliverUserEcommerceController@banned')->name('deliver.banned');

        /*assign */
        Route::get('order/deliver/list', 'DeliverUserEcommerceController@ordersList')->name('deliver.order.list');

        /*assign deliver get*/
        Route::get('deliver/assign/{id}', 'DeliverUserEcommerceController@assignCreate')->name('deliver.assign');
        Route::post('deliver/assign', 'DeliverUserEcommerceController@assignStore')->name('deliver.store');
        Route::get('deliver/assign/details/{id}', 'DeliverUserEcommerceController@assignDetails')->name('deliver.assign.details');
        Route::get('deliver/orderDelivered', 'DeliverUserEcommerceController@orderDelivered')->name('deliver.allDeliver');
    }

});

if (vendorActive()){
    /*for deliver register*/
    Route::get('deliver/register', 'DeliverUserController@register')->name('deliver.signup');
    Route::post('deliver/register', 'DeliverUserController@registerStore')->name('deliver.register');
}else{
    /*for deliver register*/
    Route::get('deliver/register', 'DeliverUserEcommerceController@register')->name('deliver.signup');
    Route::post('deliver/register', 'DeliverUserEcommerceController@registerStore')->name('deliver.register');
}

Route::get('dashboard/deliver/profile', 'DeliverUserController@profile')->name('deliver.profile');
Route::post('dashboard/deliver/user/update', 'DeliverUserController@userUpdate')->name('deliver.update');



