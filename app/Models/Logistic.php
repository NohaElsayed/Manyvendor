<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logistic extends Model
{

  protected $guarded = ['id'];

  public function scopeActive($query){
      return  $query->where('is_active', 1)->get();
  }

}
