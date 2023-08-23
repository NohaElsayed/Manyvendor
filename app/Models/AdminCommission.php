<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AdminCommission extends Model
{
    //

    public function user(){
        return $this->hasOne(User::class,'id','confirm_by');
    }
}
