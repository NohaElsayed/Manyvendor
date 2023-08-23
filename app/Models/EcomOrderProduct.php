<?php

namespace App\Models;

use App\DeliverAssign;
use App\EcomDeliverAssign;
use App\EcomProductVariantStock;
use App\User;
use Illuminate\Database\Eloquent\Model;

class EcomOrderProduct extends Model
{
    //
    /**
     * Relation with product
     */

    public function product()
    {
        return $this->hasOne(Product::class,'sku','sku');
    }

    /**
     * Relation with product
     */

    public function product_stock()
    {
        return $this->hasOne(EcomProductVariantStock::class,'id','product_stock_id');
    }


    /**
     * Relation with Logistic
     */

    public function logistic()
    {
        return $this->hasOne(Logistic::class,'id','logistic_id');
    }

    /**
     * Relation with order
     */

    public function order()
    {
        return $this->hasOne(EcomOrder::class,'id','order_id');
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
        return $this->hasOne(EcomDeliverAssign::class,'order_id','id');
    }
}
