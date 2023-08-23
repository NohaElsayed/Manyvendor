<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\VendorProduct;

class ProductExportBySeller implements FromCollection
{

     // varible form and to 

    public $seller_id  = '';

     public function __construct($seller_id)
     {
         $this->seller_id = $seller_id;
     }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
      $seller_products = VendorProduct::where('user_id', $this->seller_id)
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
