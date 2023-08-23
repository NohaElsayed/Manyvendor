<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Product;
use Auth;
use App\VendorProduct;

class ProductExportByCategory implements FromCollection
{

     // varible form and to 

    public $category_id  = '';

     public function __construct($category_id)
     {
         $this->category_id = $category_id;
     }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        // Admin
        if (Auth::user()->user_type == 'Admin') {
            return Product::where('category_id', $this->category_id)->get();
        }

        // Vendor
        if (Auth::user()->user_type == 'Vendor') {
            $seller_products = VendorProduct::where('user_id', Auth::user()->id)
            ->where('category_id', $this->category_id)
            ->with('product')
            ->get();
            $product  = collect();
            foreach($seller_products as $seller_product){
                if ($seller_product->product != null) {
                    $product->push($seller_product->product);
                }
            }
            return $product;
        }

    }
}
