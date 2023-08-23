<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        if (vendorActive()) {
            $this->mapSellerRoutes();
        }

        $this->mapFrontendRoutes();

        $this->mapbackendRoutes();

        if (paytmRoute()) {
        // Paytm Route Map
            $this->mapPaytmRoutes();
        // paytm route goes here
        }

        if (ProductExportImportRoute()) {
        // ProductExportImport Route Map
            $this->mapProductExportImportRoutes();
        // ProductExportImport route goes here
        }

        if (SslRoute()) {
        // ProductExportImport Route Map
            $this->sslcommerzRoute();
        // ProductExportImport route goes here
        }


        if (affiliateRoute()) {
        // affiliate Route Map
            $this->mapAffiliateRoutes();
        // affiliate route goes here
        }

        if(deliverActive()){
            $this->mapDeliverRoutes();
        }


        //END
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapDeliverRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/deliver.php'));
    }



    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapSellerRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/seller.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "frontend" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapFrontendRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/frontend.php'));
    }

    /**
     * Define the "backend" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapbackendRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/backend.php'));
    }

    /**
    * PayTM
    */
    protected function mapPaytmRoutes()
    {
        if (paytmRoute()) {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paytm.php'));
        }
    }

    
    /**
    * ProductExportImport
    */
    protected function mapProductExportImportRoutes()
    {
        if (ProductExportImportRoute()) {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/productexportimport.php'));
        }
    }
    
    /**
    * ProductExportImport
    */
    
    protected function sslcommerzRoute()
    {
        if (SslRoute()) {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/sslcommerz.php'));
        }
    }


    /**
     * Affiliate
     */

    protected function mapAffiliateRoutes()
    {
        if (affiliateRoute()) {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/affiliate.php'));
        }
    }

    //END

}
