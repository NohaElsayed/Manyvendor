<?php

namespace App\Http\Controllers;

use http\Client\Response;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use App\Exports\SellerProductExport;
use App\Exports\ProductExportBydate;
use App\Exports\ProductExportByCategory;
use App\Exports\ProductExportByBrand;
use App\Exports\ProductExportBySeller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use Carbon\Carbon;
use App\Models\Category;
use App\Models\Brand;
use App\Vendor;
use App\VendorProduct;
use Alert;

class ProductExportImportController extends Controller
{

     /**
     * PRODUCT EXPORT
     */

     public function export()
     {
         return Excel::download(new ProductsExport, 'products.csv');
     }

    /**
     * BLANK CSV
     */

    public function blank_csv()
    {
        $file= base_path(). "/addons/product-export-import/blank_csv.csv";
        $headers = array(
            'Content-Type: application/csv',
        );
        return response()->download($file, 'blank_csv.csv', $headers);
    }

    /**
     * SELLER EXPORT
     */

    public function seller_export()
    {
        return Excel::download(new SellerProductExport, 'products.csv');
    }

     
    /**
     * PRODUCT EXPORT BYDATE
     */

     public function bydate()
     {
         return view('backend.products.product.bydate');
     }

     public function bydateDownload(Request $request)
     {
         $from = Carbon::parse($request->export_from);
         $to = Carbon::parse($request->export_to);
         $formateFrom = Carbon::parse($request->export_from)->format('d-m-y');
         $formateTo = Carbon::parse($request->export_to)->format('d-m-y');
         $fileName = $formateFrom . '-to-' . $formateTo;
         return Excel::download(new ProductExportBydate($from, $to), 'bydate-'. $fileName .'.csv');
     }

     
    /**
     * PRODUCT EXPORT bycategory
     */

     public function bycategory()
     {
         $categories = Category::Published()->get();
         return view('backend.products.product.bycategory', compact('categories'));
     }

     public function bycategoryDownload(Request $request)
     {
         $category_id = $request->category_id;
         return Excel::download(new ProductExportByCategory($category_id), 'bycategory.csv');
     }
     
    /**
     * PRODUCT EXPORT bybrand
     */

     public function bybrand()
     {
         $brands = Brand::Published()->get();
         return view('backend.products.product.bybrand', compact('brands'));
     }

     
     public function bybrandDownload(Request $request)
     {
         $brand_id = $request->brand_id;
         return Excel::download(new ProductExportByBrand($brand_id), 'bybrand.csv');
     }

     
    /**
     * PRODUCT EXPORT byseller
     */

     public function byseller()
     {
         $sellers = Vendor::Approved()->get();
         return view('backend.products.product.byseller', compact('sellers'));
     }
     
     
     public function bysellerDownload(Request $request)
     {
         $seller_id = $request->seller_id; // actually user_id
         return Excel::download(new ProductExportByBrand($seller_id), 'byseller.csv');
     }

    /**
     * PRODUCT IMPORT
     */

     public function import()
     {
         return view('backend.products.product.import');
     }

    /**
     * PRODUCT IMPORT STORE
     */

     public function import_store(Request $request)
     {
         if ($request->hasFile('product_import')) {
             Excel::import(new ProductsImport, $request->file('product_import'));
         }

         Alert::toast('success','successs');
         return back();
     }

    //END
}
