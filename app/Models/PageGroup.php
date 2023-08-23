<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageGroup extends Model
{
    //

    public function pages(){
        return $this->hasMany(Page::class,'page_group_id','id')->with('content')->where('active',true);
    }
}
