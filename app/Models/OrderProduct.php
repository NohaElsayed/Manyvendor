<?php

namespace App\Models;

use App\DeliverAssign;
use App\User;
use App\VendorProduct;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $guarded = ['id'];

    /**
     * Relation with product
     */

     public function product()
     {
         return $this->hasOne(VendorProduct::class,'id','product_id')->with('product');
     }

    /**
     * Relation with product
     */

     public function vendor_product_stock()
     {
         return $this->hasOne(VendorProductVariantStock::class,'vendor_product_id','product_id');
     }

     /**
     * Relation with shop
     */

     public function shop()
     {
         return $this->hasOne('App\Vendor','id','shop_id');
     }

    /**
     * Relation with Logistic
     */

     public function logistic()
     {
         return $this->hasOne(Logistic::class,'id','logistic_id');
     }

    /**
     * Relation with Product SKU
     */

     public function sku()
     {
         return $this->hasOne(Product::class,'sku','sku');
     }

     /**
      * Relation with order
      */

      public function order()
     {
         return $this->hasOne(Order::class,'id','order_id');
     }

     /**
      * Relation with user
      */

      public function user()
     {
         return $this->hasOne('App\User','id','user_id');
     }

     public function deliverdBy(){
         return $this->hasOne(User::class,'id','commentedBy');
     }

     /**
      * Relation with seller
      */

      public function seller()
     {
         return $this->hasOne('App\Vendor','id','shop_id');
     }


     public function complain_booking_code_solved(){
          return $this->hasOne(Complain::class,'booking_code','booking_code')->where('status','solved');
     }

    public function complain_booking_code_untouched(){
        return $this->hasOne(Complain::class,'booking_code','booking_code')->where('status','Untouched');
    }

    public function complain_booking_code_notsolved(){
        return $this->hasOne(Complain::class,'booking_code','booking_code')->where('status','Not Solved');
    }


    //deliver assign
    public function orderAssignToDeliver(){
          return $this->hasOne(DeliverAssign::class,'order_id','id');
    }

}
