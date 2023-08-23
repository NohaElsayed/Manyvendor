<?php

namespace App\Http\Controllers\backend\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use ZipArchive;
use App\Addon;
use App\Models\Settings;
use File;
use Alert;
use Auth;
use DB;

class AddonsController extends Controller
{

    // Addons UI
    public function addons_manager()
    {
        try {
            //check DB table for migration
            if (!Schema::hasTable('addons')) {
                \Artisan::call('make:model Addon');

                Schema::create('addons', function (Blueprint $table) {
                    $table->id();
                    $table->string('name')->nullable();
                    $table->string('unique_identifier')->nullable();
                    $table->string('version')->nullable();
                    $table->boolean('activated')->default(true);
                    $table->longText('image')->default('paytm-banner.jpg');
                    $table->timestamps();
                });

                \Artisan::call('optimize:clear');
            }
            //check DB table for migration and Update Column
            if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'payment_type')) {
                DB::statement("ALTER TABLE `orders` CHANGE payment_type payment_type ENUM('cod','stripe','paypal','paytm','ssl-commerz')");
            }

            $check_model = File::exists(base_path() . '/app/Addon.php');

            $addons = Addon::all();
            return view('backend.addons.index', compact('addons'));

        } catch (\Throwable $th) {
            Alert::toast(translate('Something went wrong'), translate('error'));
            return back();
        }

    }

    // addon_status
    public function addon_status($addon)
    {

        // Store to DB
        $status = Addon::where('name', $addon)->first();

        try {
            if ($status->activated == 0) {
                $status->activated = 1;

                switch ($status->name) {
                    case 'paytm':
                        overWriteEnvFile('PAYTM_ACTIVE', 'YES');
                        break;

                    case 'product_export_import':
                        overWriteEnvFile('PRODUCTEXPORTIMPORT_ACTIVE', 'YES');
                        break;

                    case 'ssl_commerz':
                        overWriteEnvFile('SSL_COMMERZ_ACTIVE', 'YES');
                        break;

                    case 'affiliate_marketing':
                        overWriteEnvFile('AFFILIATE_MARKETING', 'YES');
                        break;
                    
                    default:
                        Alert::toast(translate('Something went wrong'), translate('success'));
                        return back();
                        break;
                }


            } else {
                $status->activated = 0;
                
                switch ($status->name) {
                    case 'paytm':
                        overWriteEnvFile('PAYTM_ACTIVE', 'NO');
                        break;

                    case 'product_export_import':
                        overWriteEnvFile('PRODUCTEXPORTIMPORT_ACTIVE', 'NO');
                        break;

                    case 'ssl_commerz':
                        overWriteEnvFile('SSL_COMMERZ_ACTIVE', 'NO');
                        break;

                    case 'affiliate_marketing':
                        overWriteEnvFile('AFFILIATE_MARKETING', 'NO');
                        break;
                    
                    default:
                        Alert::toast(translate('Something went wrong'), translate('success'));
                        return back();
                        break;
                }
            }

            $status->save();
            // Store to DB:END

            Alert::toast(translate('Status Changed'), translate('success'));
            return back();
        } catch (\Throwable $th) {
            Alert::toast(translate('Something went wrong'), translate('error'));
            return back();
        }


    }

    // addon_preview
    public function addon_preview($addon)
    {
        $preview_addon = Addon::where('name', $addon)->first();
        return view('backend.addons.preview_modal', compact('preview_addon'));
    }

    // Addons UI
    public function installui()
    {
        return view('backend.addons.install');
    }

    // addon_paytm_setup
    public function addon_setup($addon)
    {
        return redirect()->route('addons.purchase_code.verify',$addon);

        try {
            // paytm
            if ($addon == 'paytm') {
                return view('backend.addons.setup.paytm.paytm', compact('addon'));
                return view('backend.addons.setup.paytm.paytm', compact('addon'));
            }
            // product_export_import
            if ($addon == 'product_export_import') {
                return view('backend.addons.setup.product_export_import.product_export_import', compact('addon'));
            }
            // ssl_commerz
            if ($addon == 'ssl_commerz') {
                return view('backend.addons.setup.ssl_commerz.ssl_commerz', compact('addon'));
            }

            // affiliate marketing
            if ($addon == 'affiliate_marketing') {
                return view('backend.addons.setup.affiliate_marketing.index', compact('addon'));
            }

            // paytm::END
        } catch (\Throwable $th) {
            Alert::toast(translate('Something went wrong'), translate('error'));
            return back();
        }
    }

    // addon_paytm_setup
    public function purchase_code_verify($addon)
    {
        $addon_name = $addon;
        $purchase_code = null;

        try {

        /**
         * PAYTM
         */
    
        if ($addon == 'paytm') {
            return view('backend.addons.setup.paytm.paytm_account', compact('addon_name', 'purchase_code'));
        }

        /**
         * PRODUCT EXPORT IMPOR
         */
     
        if ($addon == 'product_export_import') {
            return view('backend.addons.setup.product_export_import.product_export_import_upload', compact('addon_name', 'purchase_code'));
        }

        /**
         * SSL COMMERZ
         */

        if ($addon == 'ssl_commerz') {
            return view('backend.addons.setup.ssl_commerz.ssl_commerz_account', compact('addon_name', 'purchase_code'));
        }
      

        /**
         * Affiliate Marketing 
         */
        
        if ($addon == 'affiliate_marketing') {
            return view('backend.addons.setup.affiliate_marketing.affiliate_upload', compact(
                'addon_name',
                'purchase_code'
            ));
        }

        } catch (\Throwable $th) {
            Alert::toast(translate('Something went wrong'), translate('error'));
            return back();
        }

    }


    // ssl_commerz_account_setup

    public function ssl_commerz_account_setup(Request $request)
    {

        try {
            $addon_name = $request->addon_name;
            $purchase_code = $request->purchase_code;
            $ssl_store_id = $request->ssl_store_id;
            $ssl_store_password = $request->ssl_store_password;

            return $this->sslFileUpload(
                $addon_name,
                $purchase_code,
                $ssl_store_id,
                $ssl_store_password
            );
        } catch (\Throwable $th) {
            Alert::toast(translate('Something went wrong'), translate('error'));
            return back();
        }

    }
    // ssl_commerz_account_setup

    //sslFileUpload
    public function sslFileUpload(
        $addon_name,
        $purchase_code,
        $ssl_store_id,
        $ssl_store_password
    )
    {
        try {
            return view('backend.addons.setup.ssl_commerz.ssl_commerz_upload', compact(
                'addon_name',
                'purchase_code',
                'ssl_store_id',
                'ssl_store_password'
            ));
        } catch (\Throwable $th) {
            Alert::toast(translate('Something went wrong'), translate('error'));
            return back();
        }

    }

    //sslFileUpload::END


    public function paytm_account_setup(Request $request)
    {

        try {
            $addon_name = $request->addon_name;
            $purchase_code = $request->purchase_code;
            $paytm_environment = $request->paytm_environment;
            $paytm_merchant_id = $request->paytm_merchant_id;
            $paytm_merchant_key = $request->paytm_merchant_key;
            $paytm_merchant_website = $request->paytm_merchant_website;
            $paytm_channel = $request->paytm_channel;
            $paytm_industry_type = $request->paytm_industry_type;

            return $this->paytmFileUpload(
                $addon_name,
                $purchase_code,
                $paytm_environment,
                $paytm_merchant_id,
                $paytm_merchant_key,
                $paytm_merchant_website,
                $paytm_channel,
                $paytm_industry_type
            );
        } catch (\Throwable $th) {
            Alert::toast(translate('Something went wrong'), translate('error'));
            return back();
        }


    }

    public function paytmFileUpload(
        $addon_name,
        $purchase_code,
        $paytm_environment,
        $paytm_merchant_id,
        $paytm_merchant_key,
        $paytm_merchant_website,
        $paytm_channel,
        $paytm_industry_type
    )
    {

        try {
            return view('backend.addons.setup.paytm.paytm_upload', compact(
                'addon_name',
                'purchase_code',
                'paytm_environment',
                'paytm_merchant_id',
                'paytm_merchant_key',
                'paytm_merchant_website',
                'paytm_channel',
                'paytm_industry_type'
            ));
        } catch (\Throwable $th) {
            Alert::toast(translate('Something went wrong'), translate('error'));
            return back();
        }

    }


    // Extracting Addons to addons folder

    public function index(Request $request)
    {

        // try {
            if ($file = $request->file('addons')) { //-----1

                /**
                 * Zip Upload
                 */

                $name = $file->getClientOriginalName(); // file name
                $file->move(base_path('addons/'), $name); // storing file
                $fileNameWithoutExtension = explode('.', $name)[0]; // Filename without extension

                    // Redirecting to Addons function
                    if ($fileNameWithoutExtension === 'ssl-commerz') { //-----ssl-commerz

                        if (!SslRoute()) {
                            $addon_name = $request->addon_name;
                            $purchase_code = $request->purchase_code;
                            $ssl_store_id = $request->ssl_store_id;
                            $ssl_store_password = $request->ssl_store_password;

                            // calling sslCommerz()
                            return $this->sslCommerz($addon_name, $purchase_code, $ssl_store_id, $ssl_store_password);
                            // calling sslCommerz():END
                        }else{
                            Alert::toast(translate('Addon Already Installed'), translate('error'));
                            return redirect()->route('addons.manager.index');
                        }

                        
                    } else if ($fileNameWithoutExtension === 'paytm') {


                        if (!paytmRouteForBlade()) {
                            $addon_name = $request->addon_name;
                            $purchase_code = $request->purchase_code;
                            $paytm_environment = $request->paytm_environment;
                            $paytm_merchant_id = $request->paytm_merchant_id;
                            $paytm_merchant_key = $request->paytm_merchant_key;
                            $paytm_merchant_website = $request->paytm_merchant_website;
                            $paytm_channel = $request->paytm_channel;
                            $paytm_industry_type = $request->paytm_industry_type;

                            // calling payTM()
                            return $this->paytm(
                                $addon_name,
                                $purchase_code,
                                $paytm_environment,
                                $paytm_merchant_id,
                                $paytm_merchant_key,
                                $paytm_merchant_website,
                                $paytm_channel,
                                $paytm_industry_type
                            );
                            // calling payTM():END
                        }else{
                            Alert::toast(translate('Addon Already Installed'), translate('error'));
                            return redirect()->route('addons.manager.index');
                        }

                        
                    } else if ($fileNameWithoutExtension === 'product-export-import') {

                        if (!ProductExportImportRoute()) {
                            $addon_name = $request->addon_name;
                            $purchase_code = $request->purchase_code;
                            // calling productExportImport()
                            return $this->productExportImport(
                                $addon_name,
                                $purchase_code
                            );
                            // calling productExportImport():END
                        }else{
                            Alert::toast(translate('Addon Already Installed'), translate('error'));
                            return redirect()->route('addons.manager.index');
                        }

                        

                    } else if($fileNameWithoutExtension === 'affiliate_marketing'){

                        if (!affiliateRoute()) {
                            $addon_name = $request->addon_name;
                            $purchase_code = $request->purchase_code;
                            return $this->affiliate_marketing($addon_name, $purchase_code);
                        }else{
                            Alert::toast(translate('Addon Already Installed'), translate('error'));
                            return redirect()->route('addons.manager.index');
                        }
                    

                } else { //------3
                        Alert::toast(translate('Invalid Addon File'), translate('error'));
                        return redirect()->route('addons.manager.index');
                    }
                    // Redirecting to Addons function::END

            } else { //------1
                Alert::toast(translate('Invalid Addon File'), translate('error'));
                return redirect()->route('addons.manager.index');
            }

        // } catch (\Throwable $th) {
        //     Alert::toast(translate('Something went wrong'), translate('error'));
        //     return back();
        // }


    }

    // Extracting Addons to addons folder:END


// sslCommerz::START

    public function sslCommerz($addon_name, $purchase_code, $ssl_store_id, $ssl_store_password)
    {

        try {
            // Store to DB
            $ssl = new Addon();
            $ssl->name = $addon_name;
            $ssl->unique_identifier = $purchase_code;
            $ssl->version = 1.0;
            $ssl->activated = true;
            $ssl->image = 'ssl-commerz-banner.jpg';
            $ssl->save();
            // Store to DB:END

            /**
             * Extract
             */

            $zip = new ZipArchive;

            $public_dir = base_path() . '/addons'; //addons path

            $extract_dir = base_path() . '/addons'; // extracted addons path

            $zipFileName = 'ssl-commerz.zip'; // Uploaded addons name

            $filetopath = $public_dir . '/' . $zipFileName; // find addons file

            if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
                $zip->extractTo($extract_dir); // extracting zip
                $zip->close();

                unlink(base_path() . '/addons/' . $zipFileName);
            }

            /**
             * Move Files to Folder
             */

            /**
             * Config
             */

            //  \addons\ssl-commerz\config
            $config_from_path = base_path() . '/addons/ssl-commerz/config/sslcommerz.php'; // From folder path
            $config_to_path = base_path() . '/config/sslcommerz.php'; // Coping to folder Path


            File::copy($config_from_path, $config_to_path);

            /**
             * Config:END
             */

            /**
             * Library/sslcommerz
             */

            //  /addons/ssl-commerz/app/Library/sslcommerz
            $library_from_path = base_path() . '/addons/ssl-commerz/app/Library/SslCommerz'; // From folder path
            $library_to_path = base_path() . '/app/Library/SslCommerz'; // Coping to folder Path

            File::copyDirectory($library_from_path, $library_to_path);

            /**
             * Library/sslcommerz:END
             */

            /**
             * Controller
             */

            //  /addons/ssl-commerz/app/Library/sslcommerz
            $controller_from_path = base_path() . '/addons/ssl-commerz/app/Http/Controllers/SslCommerzPaymentController.php'; // From folder path
            $controller_to_path = base_path() . '/app/Http/Controllers/SslCommerzPaymentController.php'; // Coping to folder Path

            File::copy($controller_from_path, $controller_to_path);

            /**
             * Controller:END
             */


            /**
             * Route
             */

            //  /addons/ssl-commerz/app/Library/sslcommerz
            $route_from_path = base_path() . '/addons/ssl-commerz/routes/sslcommerz.php'; // From folder path
            $route_to_path = base_path() . '/routes/sslcommerz.php'; // Coping to folder Path

            File::copy($route_from_path, $route_to_path);


            //  ENV
            overWriteEnvFile('STORE_ID', $ssl_store_id);
            overWriteEnvFile('STORE_PASSWORD', $ssl_store_password);
            overWriteEnvFile('SSL_COMMERZ_ACTIVE', "YES");
            //  ENV::END

            /**
             * Route:END
             */

            Alert::toast(translate('Package installed'), translate('success'));
            return redirect()->route('addons.manager.index');

        } catch (\Throwable $th) {
            Alert::toast(translate('Installation Failed'), translate('error'));
            return back();
        }


    }
// sslCommerz::END

    // paytm::START
    public function paytm(
        $addon_name,
        $purchase_code,
        $paytm_environment,
        $paytm_merchant_id,
        $paytm_merchant_key,
        $paytm_merchant_website,
        $paytm_channel,
        $paytm_industry_type
    )
    {

        try {
            // Store to DB
            $paytm = new Addon();
            $paytm->name = $addon_name;
            $paytm->unique_identifier = $purchase_code;
            $paytm->version = 1.0;
            $paytm->activated = true;
            $paytm->image = 'paytm-banner.jpg';
            $paytm->save();
            // Store to DB:END

            // Overwrite ENV


            overWriteEnvFile('PAYTM_ENVIRONMENT', $paytm_environment);
            overWriteEnvFile('PAYTM_MERCHANT_ID', $paytm_merchant_id);
            overWriteEnvFile('PAYTM_MERCHANT_KEY', $paytm_merchant_key);
            overWriteEnvFile('PAYTM_MERCHANT_WEBSITE', $paytm_merchant_website);
            overWriteEnvFile('PAYTM_CHANNEL', $paytm_channel);
            overWriteEnvFile('PAYTM_INDUSTRY_TYPE', $paytm_industry_type);
            overWriteEnvFile('PAYTM_ACTIVE', 'YES');


            // Overwrite ENV:END

            /**
             * Extract
             */

            $zip = new ZipArchive;

            $public_dir = base_path() . '/addons'; //addons path

            $extract_dir = base_path() . '/addons'; // extracted addons path

            $zipFileName = 'paytm.zip'; // Uploaded addons name

            $filetopath = $public_dir . '/' . $zipFileName; // find addons file

            if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
                $zip->extractTo($extract_dir); // extracting zip
                $zip->close();

                unlink(base_path() . '/addons/' . $zipFileName);
            }

            /**
             * Move Files to Folder
             */


            /**
             * Controller
             */

            //  /addons/patym/controllers
            $controller_from_path = base_path() . '/addons/paytm/Controllers/PaytmController.php'; // From folder path
            $controller_to_path = base_path() . '/app/Http/Controllers/PaytmController.php'; // Coping to folder Path

            File::copy($controller_from_path, $controller_to_path);

            /**
             * Controller:END
             */

            /**
             * Route
             */

            //  /addons/paytm/paytm.php
            $route_from_path = base_path() . '/addons/paytm/paytm.php'; // From folder path
            $route_to_path = base_path() . '/routes/paytm.php'; // Coping to folder Path

            File::copy($route_from_path, $route_to_path);

            /**
             * Route:END
             */

            Alert::toast(translate('success'), translate('Package installed'));
            return redirect()->route('addons.manager.index');

        } catch (\Throwable $th) {
            Alert::toast(translate('Installation Failed'), translate('error'));
            return back();
        }

    }

    // paytm::END


    // productExportImport::START
    public function productExportImport($addon_name, $purchase_code)
    {

        try {

            // Store to DB
            $paytm = new Addon();
            $paytm->name = $addon_name;
            $paytm->unique_identifier = $purchase_code;
            $paytm->version = 1.0;
            $paytm->activated = true;
            $paytm->image = 'productExportImport-banner.jpg';
            $paytm->save();
            // Store to DB:END

            /**
             * Extract
             */

            $zip = new ZipArchive;

            $public_dir = base_path() . '/addons'; //addons path

            $extract_dir = base_path() . '/addons'; // extracted addons path

            $zipFileName = 'product-export-import.zip'; // Uploaded addons name

            $filetopath = $public_dir . '/' . $zipFileName; // find addons file

            if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
                $zip->extractTo($extract_dir); // extracting zip
                $zip->close();

                unlink(base_path() . '/addons/' . $zipFileName);
            }

            /**
             * Move Files to Folder
             */

            /**
             * Controller
             */

            //  /addons/product-export-import/app/Http/Controllers
            $controller_from_path = base_path() . '/addons/product-export-import/app/Http/Controllers/ProductExportImportController.php'; // From folder path
            $controller_to_path = base_path() . '/app/Http/Controllers/ProductExportImportController.php'; // Coping to folder Path

            File::copy($controller_from_path, $controller_to_path);

            /**
             * Controller:END
             */


            /**
             * Export
             */

            //  /addons/patym/controllers
            $export_from_path = base_path() . '/addons/product-export-import/app/Exports'; // From folder path
            $export_to_path = base_path() . '/app/Exports'; // Coping to folder Path

            File::copyDirectory($export_from_path, $export_to_path);

            /**
             * Export:END
             */


            /**
             * Import
             */

            //  /addons/patym/controllers
            $import_from_path = base_path() . '/addons/product-export-import/app/Imports'; // From folder path
            $import_to_path = base_path() . '/app/Imports'; // Coping to folder Path

            File::copyDirectory($import_from_path, $import_to_path);

            /**
             * Import:END
             */

            /**
             * Route
             */

            //  /addons/paytm/paytm.php
            $route_from_path = base_path() . '/addons/product-export-import/routes/productexportimport.php'; // From folder path
            $route_to_path = base_path() . '/routes/productexportimport.php'; // Coping to folder Path

            File::copy($route_from_path, $route_to_path);

            /**
             * Route:END
             */

            /**
             * View
             */

            //  /addons/paytm/paytm.php
            $import = base_path() . '/addons/product-export-import/resources/views/backend/products/product/import.blade.php';
            $bybrand = base_path() . '/addons/product-export-import/resources/views/backend/products/product/bybrand.blade.php';
            $bycategory = base_path() . '/addons/product-export-import/resources/views/backend/products/product/bycategory.blade.php';
            $bydate = base_path() . '/addons/product-export-import/resources/views/backend/products/product/bydate.blade.php';
            $byseller = base_path() . '/addons/product-export-import/resources/views/backend/products/product/byseller.blade.php';
            $view_from_path = array($import, $bybrand, $bycategory, $bydate, $byseller); // From folder path

            $to_import = base_path() . '/resources/views/backend/products/product/import.blade.php';
            $to_bybrand = base_path() . '/resources/views/backend/products/product/bybrand.blade.php';
            $to_bycategory = base_path() . '/resources/views/backend/products/product/bycategory.blade.php';
            $to_bydate = base_path() . '/resources/views/backend/products/product/bydate.blade.php';
            $to_byseller = base_path() . '/resources/views/backend/products/product/byseller.blade.php';
            $view_to_path = array($to_import, $to_bybrand, $to_bycategory, $to_bydate, $to_byseller); // Coping to folder Path

            $i = 0;
            foreach ($view_from_path as $from) {
                copy($from, $view_to_path[$i]);
                $i++;
            }

            /**
             * View:END
             */

            // Overwrite ENV
            overWriteEnvFile('PRODUCTEXPORTIMPORT_ACTIVE', 'YES');
            // Overwrite ENV:END

            Alert::toast(translate('success'), translate('Package installed'));
            return redirect()->route('addons.manager.index');

        } catch (\Throwable $th) {
            Alert::toast(translate('Installation Failed'), translate('error'));
            return back();
        }


    }

    // productExportImport::END



     // affiliate::START
    public function affiliate_marketing($addon_name, $purchase_code)
    {

        // Store to DB
        $paytm = new Addon();
        $paytm->name = $addon_name;
        $paytm->unique_identifier = $purchase_code;
        $paytm->version = 1.0;
        $paytm->activated = true;
        $paytm->image = 'affiliate-system-banner.jpg';
        $paytm->save();
        // Store to DB:END

        //Extract
        $zip = new ZipArchive;
        $public_dir=base_path().'/addons'; //addons path
        $extract_dir=base_path().'/addons'; // extracted addons path
        $zipFileName = 'affiliate_marketing.zip'; // Uploaded addons name

        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
            $zip->extractTo($extract_dir); // extracting zip
            $zip->close();
            unlink(base_path().'/addons/'.$zipFileName);
        }

        //Move Files to Project Folder

        // Controller
        $controller_from_path = base_path().'/addons/affiliate_marketing/Controllers/affiliate'; // From folder path
        $controller_to_path = base_path() . '/app/Http/Controllers/affiliate'; // Coping to folder Path
        File::copyDirectory($controller_from_path, $controller_to_path);

        

        //middleware
        $affiliateApprovedUser = base_path().'/addons/affiliate_marketing/Middleware/affiliateApprovedUser.php';
        $affiliateNonApprovedUser = base_path().'/addons/affiliate_marketing/Middleware/affiliateNonApprovedUser.php';
        $AffiliationCodeCheck = base_path().'/addons/affiliate_marketing/Middleware/AffiliationCodeCheck.php';
        $middleware_from_path = array($affiliateApprovedUser, $affiliateNonApprovedUser,$AffiliationCodeCheck); // From folder path

        $to_affiliateApprovedUser = base_path().'/app/Http/Middleware/affiliateApprovedUser.php';
        $to_affiliateNonApprovedUser = base_path().'/app/Http/Middleware/affiliateNonApprovedUser.php';
        $to_AffiliationCodeCheck = base_path().'/app/Http/Middleware/AffiliationCodeCheck.php';
        $middleware_to_path = array($to_affiliateApprovedUser, $to_affiliateNonApprovedUser, $to_AffiliationCodeCheck); // Coping to folder Path
        $i =0;
        foreach ($middleware_from_path as $from){
            copy($from, $middleware_to_path[$i]);
            $i++;
        }

        


        //Models
        $AffiliateAccount = base_path().'/addons/affiliate_marketing/Models/AffiliateAccount.php';
        $AffiliatePaidHistory = base_path().'/addons/affiliate_marketing/Models/AffiliatePaidHistory.php';
        $AffiliatePaymentsAccount = base_path().'/addons/affiliate_marketing/Models/AffiliatePaymentsAccount.php';
        $AffiliateSellHistory = base_path().'/addons/affiliate_marketing/Models/AffiliateSellHistory.php';
        $model_from_path = array($AffiliateAccount, $AffiliatePaidHistory,$AffiliatePaymentsAccount,$AffiliateSellHistory); // From folder path

        $to_AffiliateAccount = base_path().'/app/Models/AffiliateAccount.php';
        $to_AffiliatePaidHistory = base_path().'/app/Models/AffiliatePaidHistory.php';
        $to_AffiliatePaymentsAccount = base_path().'/app/Models/AffiliatePaymentsAccount.php';
        $to_AffiliateSellHistory = base_path().'/app/Models/AffiliateSellHistory.php';
        $model_to_path = array($to_AffiliateAccount, $to_AffiliatePaidHistory, $to_AffiliatePaymentsAccount,$to_AffiliateSellHistory); // Coping to folder Path
        $j =0;
        foreach ($model_from_path as $from1){
            copy($from1, $model_to_path[$j]);
            $j++;
        }

        //Notifications
        $AffiliateApprovalToUser = base_path().'/addons/affiliate_marketing/Notifications/AffiliateApprovalToUser.php';
        $AffiliateBlockUser = base_path().'/addons/affiliate_marketing/Notifications/AffiliateBlockUser.php';
        $AffiliatePaymentCancellation = base_path().'/addons/affiliate_marketing/Notifications/AffiliatePaymentCancellation.php';
        $AffiliatePaymentConfirmation = base_path().'/addons/affiliate_marketing/Notifications/AffiliatePaymentConfirmation.php';
        $AffiliateReduceUserCommission = base_path().'/addons/affiliate_marketing/Notifications/AffiliateReduceUserCommission.php';
        $AffiliateUnblockUser = base_path().'/addons/affiliate_marketing/Notifications/AffiliateUnblockUser.php';
        $AffiliateUserCommission = base_path().'/addons/affiliate_marketing/Notifications/AffiliateUserCommission.php';
        $notification_from_path = array($AffiliateApprovalToUser, $AffiliateBlockUser,$AffiliatePaymentCancellation,$AffiliatePaymentConfirmation, $AffiliateReduceUserCommission,$AffiliateUnblockUser,$AffiliateUserCommission); // From folder path

        $to_AffiliateApprovalToUser = base_path().'/app/Notifications/AffiliateApprovalToUser.php';
        $to_AffiliateBlockUser = base_path().'/app/Notifications/AffiliateBlockUser.php';
        $to_AffiliatePaymentCancellation = base_path().'/app/Notifications/AffiliatePaymentCancellation.php';
        $to_AffiliatePaymentConfirmation = base_path().'/app/Notifications/AffiliatePaymentConfirmation.php';
        $to_AffiliateReduceUserCommission = base_path().'/app/Notifications/AffiliateReduceUserCommission.php';
        $to_AffiliateUnblockUser = base_path().'/app/Notifications/AffiliateUnblockUser.php';
        $to_AffiliateUserCommission = base_path().'/app/Notifications/AffiliateUserCommission.php';
        $notification_to_path = array($to_AffiliateApprovalToUser, $to_AffiliateBlockUser,$to_AffiliatePaymentCancellation,$to_AffiliatePaymentConfirmation, $to_AffiliateReduceUserCommission,$to_AffiliateUnblockUser,$to_AffiliateUserCommission); // Coping to folder Path
        $k =0;
        foreach ($notification_from_path as $from2){
            copy($from2, $notification_to_path[$k]);
            $k++;
        }

        //views
        //backend
        $from_backend_affiliate = base_path().'/addons/affiliate_marketing/resources/views/backend/affiliate';
        $to_backend_affiliate = base_path().'/resources/views/backend/affiliate';
        File::copyDirectory($from_backend_affiliate, $to_backend_affiliate);

        //frontend
        $from_frontend_affiliate = base_path().'/addons/affiliate_marketing/resources/views/frontend/affiliate';
        $to_frontend_affiliate = base_path().'/resources/views/frontend/affiliate';
        File::copyDirectory($from_frontend_affiliate, $to_frontend_affiliate);


        //routes
        $from_route = base_path().'/addons/affiliate_marketing/routes/affiliate.php';
        $to_route = base_path().'/routes/affiliate.php';
        File::copy($from_route, $to_route);


        try {
            //check DB table for migration
            if (!Schema::hasTable('affiliate_accounts') && !Schema::hasTable('affiliate_paid_histories') && !Schema::hasTable('affiliate_payments_accounts') && !Schema::hasTable('affiliate_sell_histories')) {
                Schema::create('affiliate_accounts', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('user_id')->unique();
                    $table->string('affiliation_code')->nullable();
                    $table->boolean('is_approved')->default(false);
                    $table->boolean('is_blocked')->default(false);//for not allowing new link generation/withdrawal/paymentSetup
                    $table->double('balance')->nullable();
                    $table->timestamps();
                });

                Schema::create('affiliate_payments_accounts', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('user_id')->unique();

                    //bank
                    $table->string('bank')->default('Bank');
                    $table->string('bank_name')->nullable();
                    $table->string('account_name')->nullable();
                    $table->string('account_number')->nullable();
                    $table->integer('routing_number')->nullable();

                    //paypal
                    $table->string('paypal')->default('Paypal');
                    $table->string('paypal_acc_name')->nullable();
                    $table->string('paypal_acc_email')->nullable();

                    //stripe
                    $table->string('stripe')->default('Stripe');
                    $table->string('stripe_acc_name')->nullable();
                    $table->string('stripe_acc_email')->nullable();
                    $table->string('stripe_card_holder_name')->nullable();
                    $table->string('stripe_card_number')->nullable();

                    //payTm
                    $table->string('payTm')->default('payTm');
                    $table->string('payTm_number')->nullable();

                    //bKash
                    $table->string('bKash')->default('bKash');
                    $table->string('bKash_number')->nullable();

                    //nagad
                    $table->string('nagad')->default('Nagad');
                    $table->string('nagad_number')->nullable();

                    //rocket
                    $table->string('rocket')->default('Rocket');
                    $table->string('rocket_number')->nullable();

                    $table->timestamps();
                });

                Schema::create('affiliate_sell_histories', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('user_id');//user who affiliates
                    $table->string('affiliation_code');//code of user who affiliates
                    $table->unsignedBigInteger('ordered_product_id');//ordered_product_id
                    $table->double('order_amount');//amount of total order
                    $table->double('amount');//amount of total commission
                    $table->boolean('is_pending')->default(1);
                    $table->timestamps();
                });

                Schema::create('affiliate_paid_histories', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('user_id'); //which affiliate user

                    $table->double('amount');//requested amount
                    $table->boolean('is_paid')->default(false); //check if paid
                    $table->boolean('is_cancelled')->default(false); //check if admin cancel the request

                    $table->string('payment_account');//requested payment method name
                    $table->dateTime('paid_date')->nullable();//paid date

                    $table->unsignedBigInteger('confirmed_by')->nullable(); //admin who pays
                    $table->timestamps();
                });

                \Artisan::call('optimize:clear');
            }

            $settings = new Settings;
            $settings->name = 'affiliate_commission';
            $settings->save();

            $settings2 = new Settings;
            $settings2->name = 'affiliate_min_withdrawal';
            $settings2->save();

            $settings3 = new Settings;
            $settings3->name = 'affiliate_cookie_limit';
            $settings3->save();

            $settings4 = new Settings;
            $settings4->name = 'affiliate_payment';
            $settings4->save();

             // Overwrite ENV
        overWriteEnvFile('AFFILIATE_MARKETING', 'YES');
        // Overwrite ENV:END

        Alert::toast(translate('success'), translate('Package installed'));
        return redirect()->route('addons.manager.index');

        } catch (\Throwable $th) {
            Alert::toast(translate('Something went wrong'), translate('error'));
            return redirect()->route('addons.manager.index');
        }

       
    }
    //affiliate end


    //END
}
