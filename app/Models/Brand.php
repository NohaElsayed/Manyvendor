<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name',
        'banner',
        'slug',
        'meta_title',
        'meta_desc',
        'is_published',
        'is_requested',
        'logo'
    ];

    /**
     * PUBLISHED
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', 1);
    }

    /**
     * RELATION WITH PRODUCT
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }


}
