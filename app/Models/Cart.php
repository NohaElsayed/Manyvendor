<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'vendor_id',
        'quantity',
        'ip',
        'variant'
    ];

    /**
     * SHOP PRODUCT
     */

    public function fromShop(){
        return $this->hasOne('App\VendorProduct','user_id','vendor_id');
    }

    /**
     * PRODUCT
     */
    public function vendor_product(){
        return $this->hasOne('App\VendorProduct','id','vendor_product_id');
    }

    /**
     * VENDOR
     */
    public function seller(){
        return $this->hasOne('App\Vendor','user_id','vendor_id');
    }

    /**
     * VARIANT
     */
    public function relationBetweenVariantProductStock(){
        return $this->hasOne('App\Models\VendorProductVariantStock','id','vpvs_id');
    }

}
