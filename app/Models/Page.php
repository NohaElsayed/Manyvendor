<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    protected $guarded = ['id'];
    
    public function scopeActive($query){
        return $query->where('active', true);
    }

    public function content(){
        return $this->hasMany(PageContent::class,'page_id','id')->Active();
    }
}
