<?php

//SSLCOMMERZ START
Route::post('/pay', 'SslCommerzPaymentController@index')->name('ssl.pay');

Route::post('/success', 'SslCommerzPaymentController@success')->name('ssl.success');
Route::post('/fail', 'SslCommerzPaymentController@fail')->name('ssl.fail');
Route::post('/cancel', 'SslCommerzPaymentController@cancel')->name('ssl.cancel');

Route::post('/ipn', 'SslCommerzPaymentController@ipn')->name('ssl.ipn');
//SSLCOMMERZ END