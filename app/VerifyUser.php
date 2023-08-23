<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyUser extends Model
{
    //

    protected $fillable = ['user_id','token'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
