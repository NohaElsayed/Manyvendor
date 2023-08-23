<?php

namespace App;

use App\Models\Category;
use App\Models\VendorProductVariantStock;
use Illuminate\Database\Eloquent\Model;

class VendorProduct extends Model
{
    protected $guarded = ['id'];

    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    public function scopeDiscounted($query)
    {
        return $query->where('is_discount', 1);
    }

    // products
    public function products()
    {
      return $this->hasOne('App\Vendor','user_id','user_id');
    }

    // product
    public function product()
    {
      return $this->hasOne('App\Models\Product','id','product_id');
    }
    public function frontProduct()
    {
        return $this->hasOne('App\Models\Product','id','product_id')->where('is_published',1);
    }

    // product
    public function sale_products()
    {
      return $this->hasMany('App\Models\Product','id','product_id');
    }

    // user
    public function user()
    {
      return $this->hasOne('App\User','id','user_id');
    }

    // user
    public function seller()
    {
      return $this->hasOne('App\Vendor','user_id','user_id');
    }

    // parentCat
    public function parentCat(){
        return $this->hasOne(Category::class,'id','parent_id');
    }

    /* Category*/
    public function category(){
        return $this->hasOne(Category::class,'id','category_id');
    }

    /*vendor product variant*/
    public function variants(){
        return $this->hasMany(VendorProductVariantStock::class,'vendor_product_id','id');
    }

    // parent_category
    public function parent_category()
    {
      return $this->hasMany('App\Models\Category','id','parent_id');
    }

    public function sub_category()
    {
      return $this->hasMany('App\Models\Category','id','category_id');
    }
    // END

    /*show vendor product variant stock*/
    public function variantProductStock(){
        return $this->hasMany(VendorProductVariantStock::class,'vendor_product_id','id');
    }
}
