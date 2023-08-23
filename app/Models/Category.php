<?php

namespace App\Models;

use App\User;
use App\VendorProduct;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

   protected $guarded = ['id'];

  public function scopePublished($query)
  {
      return $query->where('is_published', 1);
  }

  public function scopePopular($query)
  {
      return $query->where('is_popular', 1);
  }
    //for recursive menu
    public function childrenCategories()
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'id')->with('products')->Published()->with('childrenCategories');
    }

    public function subCategory(){
      return $this->hasMany(Category::class,'parent_category_id','id')->Published()->with('vendor');
    }

    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_category_id');
    }

    /*for commission relation*/
    public function commission(){
        return $this->hasOne(Commission::class,'id','commission_id');
    }

    /*creator details*/
    public function creator(){
        return $this->hasOne(User::class,'id','user_id');
    }


    /*parent categories for frontend*/
    public function frontParentCat(){
        return $this->hasMany(Category::class,'parent_category_id','id')->Published();
    }

    public function products(){
        return $this->hasMany(Product::class,'category_id','id')->orderByDesc('id')->with('sellers')
                    ->where('is_published',true);
    }

    public function recommended(){
        return $this->hasMany(Product::class,'category_id','id')
                    ->with('sellers')
                    ->where('is_published',true);
    }

    public function sale(){
        return $this->hasMany(Product::class,'category_id','id')
                    ->with('sellers')
                    ->where('is_published',true);
    }

    //for recursive menu
    public function promotionBanner()
    {
        return $this->hasMany(Promotion::class, 'category_id', 'id')->Published();
    }

    //Category products
    public function CategoryProducts(){
        return $this->hasMany(Product::class,'parent_id','id')
                    ->Published();
    }

    public function frontCategoryProducts(){
        return $this->hasMany(Category::class,'parent_category_id','id')->Published()->with('CategoryProducts');
    }


    //Category products
    public function subCategoryProducts(){
        return $this->hasMany(Product::class,'category_id','id')
                        ->Published();
    }

    // END
}
