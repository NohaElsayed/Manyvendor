<?php

namespace App\Models;

use App\EcomProductVariantStock;
use App\VendorProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

class Product extends Model
{

    use SerializesModels;

    protected $guarded = ['id'];

    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    /*for ecommerce*/
    public function scopeDiscounted($query)
    {
        return $query->where('is_discount', 1);
    }

    /*relation with images*/
    public function images(){
        return $this->hasMany(ProductImage::class,'product_id','id');
    }

    /*relation with variant*/
    public function variants(){
        return $this->hasMany(ProductVariant::class,'product_id','id')->where('is_published', 1)->with('variant');
    }

    /*relation with brand*/
    public function brand(){
        return $this->hasOne(Brand::class,'id','brand_id');
    }

    /*relation with category*/
    public function category(){
        return $this->hasOne(Category::class,'id','parent_id');
    }

    /*relation with childcategory*/
    public function childcategory(){
        return $this->hasOne(Category::class,'id','category_id')->with('commission');
    }

    /*relation with sellers*/
    public function sellers(){
        return $this->hasMany('App\VendorProduct','product_id','id')
                    ->orderByDesc('id')->Published();
    }

    /*seller product */
    public function vendorProduct(){
        return $this->hasMany(VendorProduct::class,'product_id','id')
            ->orderByDesc('id')->Published();
    }


    /*is ar ecommerce*/
    /*show vendor product variant stock*/
    public function variantProductStock(){
        return $this->hasMany(EcomProductVariantStock::class,'product_id','id');
    }

}
