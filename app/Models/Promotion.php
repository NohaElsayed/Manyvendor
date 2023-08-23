<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    
    protected $guarded = ['id'];

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Relation With Category
     */
    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
    
}
