<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Junges\ACL\Http\Models\Group;

class UserHasGroup extends Model
{
    protected $table = 'user_has_groups';
    
    public $timestamps = false;

    public function groups(){
        return $this->hasMany(Group::class,'id','group_id');
    }
}
