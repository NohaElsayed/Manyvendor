<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateAccount extends Model
{
    public function paymentAccount(){
        return $this->hasOne(AffiliatePaymentsAccount::class,'user_id', 'user_id');
    }
}
