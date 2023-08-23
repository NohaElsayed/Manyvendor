<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AffiliatePaidHistory extends Model
{
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function affUser(){
        return $this->hasOne(AffiliateAccount::class,'user_id','user_id');
    }

    public function adminUser(){
        return $this->hasOne(User::class,'id','confirmed_by');
    }

    public function account(){
        return $this->hasOne(AffiliatePaymentsAccount::class,'user_id','user_id');
    }
}
