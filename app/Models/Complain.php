<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $guarded = ['id'];

    /**
     * Relation with OrderProduct
     */

     public function orderproduct()
     {
         return $this->hasOne(orderProduct::class,'booking_code','booking_code');
     }

    /**
     * Relation with User
     */

     public function user()
     {
         return $this->hasOne('App\User','id','user_id');
     }

     /*ecommerce section*/
    public function ecom_order_product(){
        return $this->hasOne(EcomOrderProduct::class,'booking_code','booking_code');
    }


     //END
}
