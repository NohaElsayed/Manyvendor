<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    // scopeApproved
    public function scopeApproved($query)
    {
        return $query->where('approve_status', 1);
    }

    
    // seller_product
    public function seller_product()
    {
      return $this->hasOne('App\VendorProduct','user_id','user_id');
    }

}
