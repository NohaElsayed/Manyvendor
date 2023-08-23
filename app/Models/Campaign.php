<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use softDeletes;

     protected $dates = [
        'start_from',
        'end_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'banner',
        'offer',
        'start_from',
        'end_at',
        'active_for_seller',
        'active_for_customer',
        'meta_title',
        'meta_desc',
        'meta_image',
        'is_requested'
    ];


    public function scopeOn($query){
        return $query->where('end_at','>=',Carbon::now());
    }
}
