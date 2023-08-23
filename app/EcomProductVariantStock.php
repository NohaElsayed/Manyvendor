<?php

namespace App;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;

class EcomProductVariantStock extends Model
{
    //
    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }


    public function product(){
        return $this->hasOne(Product::class,'id','product_id');
    }
}
