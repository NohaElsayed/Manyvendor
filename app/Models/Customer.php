<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
      'user_id',
      'name',
      'email',
      'slug',
      'avatar', //nullable
      'phn_no', //nullable,
      'address',//nullable
    ];
}
