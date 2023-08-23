<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $guarded = ['id'];

    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    /**
     * RELATION WITH PRODUCT VARIANT
     */

     public function product_variant()
     {
         return $this->hasOne(ProductVariant::class, 'variant_id', 'id');
     }


    //END
}
