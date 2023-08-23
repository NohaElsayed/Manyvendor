<?php

Route::group(['middleware' => ['installed' , 'auth']], function () {
    //check if affiliate is installed & active
    if (affiliateActive()) {
        //frontend

            //non approved user routes
            Route::group(['middleware' => ['affiliateNonApprovedUser']], function () {
                Route::get('/affiliate-profile', 'affiliate\frontend\AffiliateController@index')->name('customers.affiliate.registration'); //registration view
                Route::post('/affiliate-registration', 'affiliate\frontend\AffiliateController@store')->name('customers.affiliate.store'); //store reg request
            });

            //approved user routes
            Route::group(['middleware' => ['affiliateApprovedUser']], function () {
                //general routes
                Route::get('/generate-product-link', 'affiliate\frontend\AffiliateController@productLink')->name('customers.affiliate.productLink');
                Route::get('/earning-histories', 'affiliate\frontend\AffiliateController@earningHistory')->name('customers.affiliate.earningHistory');
                Route::get('/payment-histories', 'affiliate\frontend\AffiliateController@paymentHistory')->name('customers.affiliate.paymentHistory');
                Route::get('/set-payment-accounts', 'affiliate\frontend\AffiliateController@setPaymentAccounts')->name('customers.affiliate.setPaymentAccounts');
                Route::get('/withdraw-affiliated-money', 'affiliate\frontend\AffiliateController@withdrawAffiliatedMoney')->name('customers.affiliate.withdrawAffiliatedMoney');

                //affiliate payment account setup
                Route::post('/save-payment-accounts','affiliate\frontend\AffiliateController@storePaymentAccounts')->name('customers.affiliate.storePaymentAccounts');

                //affiliate payment withdrawal request
                Route::post('/save-withdrawal-request','affiliate\frontend\AffiliateController@storeWithdrawAffiliatedMoney')->name('customers.affiliate.storeWithdrawAffiliatedMoney');
                Route::get('/delete-withdrawal-request-blade/{id}','affiliate\frontend\AffiliateController@deleteRequestBlade')->name('customers.affiliate.deleteRequestBlade');
                Route::post('/delete-withdrawal-request','affiliate\frontend\AffiliateController@deleteRequest')->name('customers.affiliate.deleteRequest');


                //earning history filter
                Route::post('/earning-histories-filter', 'affiliate\frontend\AffiliateController@earningHistoryFilter')->name('customers.affiliate.earningHistoryFilter');

                //payment History filter
                Route::post('/payment-histories-filter-pending', 'affiliate\frontend\AffiliateController@pendingPaymentHistoryFilter')->name('customers.affiliate.pendingPaymentHistoryFilter');
                Route::post('/payment-histories-filter-paid', 'affiliate\frontend\AffiliateController@paidPaymentHistoryFilter')->name('customers.affiliate.paidPaymentHistoryFilter');
                Route::post('/payment-histories-filter-cancelled', 'affiliate\frontend\AffiliateController@cancelledPaymentHistoryFilter')->name('customers.affiliate.cancelledPaymentHistoryFilter');
            });


        //backend
        Route::group(['middleware' => 'permissions:affiliate-management', 'prefix' => 'dashboard'], function () {
            //accounts
            Route::get('/affiliate-accounts', 'affiliate\backend\AffiliateController@index')->name('admins.affiliate.index');
            Route::get('/affiliate-accounts/search-active', 'affiliate\backend\AffiliateController@searchActive')->name('admins.affiliate.searchActive');
            Route::get('/affiliate-accounts/search-blocked', 'affiliate\backend\AffiliateController@searchBlocked')->name('admins.affiliate.searchBlocked');
            Route::get('/affiliate-accounts/search-requests', 'affiliate\backend\AffiliateController@searchRequests')->name('admins.affiliate.searchRequests');

            //payments
            Route::get('/affiliate-payments', 'affiliate\backend\AffiliateController@affiliatePayments')->name('admins.affiliate.affiliatePayments');
            Route::get('/affiliate-accounts/search-req-payments', 'affiliate\backend\AffiliateController@searchReqPayments')->name('admins.affiliate.searchReqPayments');
            Route::get('/affiliate-accounts/search-paid-payments', 'affiliate\backend\AffiliateController@searchPaidPayments')->name('admins.affiliate.searchPaidPayments');
            Route::get('/affiliate-accounts/search-cancelled-payments', 'affiliate\backend\AffiliateController@searchCancelledPayments')->name('admins.affiliate.searchCancelledPayments');

            //affiliate settings routes
            Route::get('/affiliate-settings', 'affiliate\backend\AffiliateController@settings')->name('admins.affiliate.settings');
            Route::post('/affiliate-settings', 'affiliate\backend\AffiliateController@storeSettings')->name('admins.affiliate.storeSettings');

            //registration request routes
            Route::get('/affiliate-requested-users', 'affiliate\backend\AffiliateController@requestedUsers')->name('admins.affiliate.requestedUsers');
            Route::get('/approve-affiliate-account/{id}','affiliate\backend\AffiliateController@approveRequest')->name('admins.affiliate.approveRequest');
            Route::get('/block-unblock-affiliate-account/{id}','affiliate\backend\AffiliateController@blockUnblockAffiliateAcc')->name('admins.affiliate.blockUnblockAffiliateAcc');
            Route::get('/delete-affiliate-reg-req/{id}','affiliate\backend\AffiliateController@delete')->name('admins.affiliate.delete');

            //affiliate payment withdrawal approval
            Route::get('/withdrawal-details/{id}','affiliate\backend\AffiliateController@withdrawalDetails')->name('admins.affiliate.withdrawalDetails');
            Route::get('/approve-withdrawal-request/{id}','affiliate\backend\AffiliateController@approveWithdrawAffiliatedMoney')->name('admins.affiliate.approveWithdrawAffiliatedMoney');
            Route::get('/cancel-withdrawal-request/{id}','affiliate\backend\AffiliateController@cancelWithdrawAffiliatedMoney')->name('admins.affiliate.cancelWithdrawAffiliatedMoney');

        });
    }
});