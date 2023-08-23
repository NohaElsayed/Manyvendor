<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Product;
use Auth;
use App\VendorProduct;

class ProductExportBydate implements FromCollection
{

      // varible form and to 

      public $from  = '';
      public $to  = '';

     public function __construct($from, $to)
     {
         $this->from = $from;
         $this->to   = $to;
     }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {

        //Admin
        if (Auth::user()->user_type == 'Admin') {
            return Product::whereBetween('created_at',[$this->from,$this->to])->get();
        }

        // Vendor
        if (Auth::user()->user_type == 'Vendor') {
            $seller_products = VendorProduct::where('user_id', Auth::user()->id)
            ->whereBetween('created_at',[$this->from,$this->to])
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

    //END
}
