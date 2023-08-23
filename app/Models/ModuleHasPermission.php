<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Junges\ACL\Http\Models\Permission;


class ModuleHasPermission extends Model
{
    protected $guarded = ['id'];

    public function module(){
        return $this->belongsTo(Module::class,'module_id','id');
    }

    public function permission(){
        return $this->belongsTo(Permission::class,'permission_id','id');
    }
    
    // END
}
