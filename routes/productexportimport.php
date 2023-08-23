<?php

/*
|--------------------------------------------------------------------------
| Product Export Import Routes
|--------------------------------------------------------------------------
*/

    Route::get('addon/product/export', 'ProductExportImportController@export')->name('admin.product.export');
    Route::get('addon/product/blank/csv', 'ProductExportImportController@blank_csv')->name('admin.product.blank.csv');
    Route::get('addon/seller/product/export', 'ProductExportImportController@seller_export')->name('seller.product.export');

    /**
     * bydate
     */
    Route::get('addon/product/export/bydate', 'ProductExportImportController@bydate')->name('admin.product.bydate');
    Route::get('addon/product/export/bydate/download', 'ProductExportImportController@bydateDownload')->name('admin.product.bydate.download');

    /**
     * bycategory
     */
    Route::get('addon/product/export/bycategory', 'ProductExportImportController@bycategory')->name('admin.product.bycategory');
    Route::get('addon/product/export/bycategory/download', 'ProductExportImportController@bycategoryDownload')->name('admin.product.bycategory.download');

    Route::get('addon/product/export/bybrand', 'ProductExportImportController@bybrand')->name('admin.product.bybrand');
    Route::get('addon/product/export/bybrand/download', 'ProductExportImportController@bybrandDownload')->name('admin.product.bybrand.download');

    Route::get('addon/product/export/byseller', 'ProductExportImportController@byseller')->name('admin.product.byseller');
    Route::get('addon/product/export/byseller/download', 'ProductExportImportController@bysellerDownload')->name('admin.product.byseller.download');


    Route::get('addon/product/import', 'ProductExportImportController@import')->name('admin.product.import');
    Route::post('addon/product/import/store', 'ProductExportImportController@import_store')->name('admin.product.import.store');