<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EcomCampaignProduct extends Model
{
    use softdeletes;
     protected $fillable = [
         'campaign_id',
         'product_id'
     ];

     public function product(){
         return $this->hasOne(Product::class,'id','product_id');
     }
}
