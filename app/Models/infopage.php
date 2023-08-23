<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class infopage extends Model
{
    //

    public function page(){
        return $this->hasOne(Page::class,'id','page_id')->with('content');
    }
}
