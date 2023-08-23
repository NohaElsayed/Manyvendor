<?php

namespace App;



use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Junges\ACL\Traits\UsersTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,UsersTrait,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function vendor()
    {
      return $this->hasOne('App\Vendor','user_id','id')->Approved();
    }

    public function customer()
    {
        return $this->hasOne('App\Models\Customer','user_id','id');
    }

    /*for mobile count the product*/
    public function productCount(){
        return $this->hasMany(VendorProduct::class,'user_id','id');
    }


    // verifyUser
    public function verifyUser(){
        return $this->hasOne(\App\VerifyUser::class,'user_id','id');
    }

    public function scopeVerify($query){
        return $query->where('verified', true);
    }


    /*this relation for assign deliver men */
    public function deliverAssign(){
        return $this->hasOne(DeliverAssign::class,'deliver_user_id','id');
    }

}
