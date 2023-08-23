<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Product;

class ProductExportByBrand implements FromCollection
{

    // varible form and to 

    public $brand_id  = '';

     public function __construct($brand_id)
     {
         $this->brand_id = $brand_id;
     }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::where('brand_id', $this->brand_id)->get();
    }
}
