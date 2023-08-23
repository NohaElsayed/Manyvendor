<?php

namespace App\Models;

use App\EcomProductVariantStock;
use Illuminate\Database\Eloquent\Model;

class EcomCart extends Model
{
    //


    public function relation_product_stock(){
        return $this->hasOne(EcomProductVariantStock::class,'id','product_stock_id');
    }
}
