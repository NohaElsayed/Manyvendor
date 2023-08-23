<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wishlist extends Model
{
    use softDeletes;

    protected $fillable = [
        'product_id',
        'user_id'
    ];

    public function product()
    {
        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
