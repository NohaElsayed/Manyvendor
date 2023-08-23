<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageContent extends Model
{

    protected $guarded = ['id'];
    
    public function scopeActive($query){
        return $query->where('active', true);
    }
}
