<?php

namespace App;

use App\Models\EcomOrderProduct;
use Illuminate\Database\Eloquent\Model;

class EcomDeliverAssign extends Model
{
    public function deliverUser()
    {
        return $this->hasOne(User::class, 'id', 'deliver_user_id');
    }


    public function assignUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function orderDetails()
    {
        return $this->hasOne(EcomOrderProduct::class, 'id', 'order_id')->with('product')->with('order');
    }

    public function deliverSummery(){
        return $this->hasMany(EcomDeliveymenTrack::class,'deliver_assign_id','id')->orderByDesc('id');
    }
}
