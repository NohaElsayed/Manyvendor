<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{

    protected $guarded = ['id'];

    /**
     * RELATION WITH VARIANT
     */
    public function variant(){
        return $this->hasOne(Variant::class,'id','variant_id');
    }

    /**
     * RELATION WITH VARIANT
     */
    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
    
    // END
}
