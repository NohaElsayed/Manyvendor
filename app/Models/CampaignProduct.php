<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignProduct extends Model
{
    use softDeletes;

    protected $guarded = ['id'];

    public function campaignProductFromShop(){
        return $this->hasOne('App\VendorProduct','user_id','vendor_id');
    }
}
