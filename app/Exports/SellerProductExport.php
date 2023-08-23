<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use App\VendorProduct;
use Auth;

class SellerProductExport implements FromCollection
{
    public function collection()
    {


        $seller_products = VendorProduct::where('user_id', Auth::user()->id)
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
