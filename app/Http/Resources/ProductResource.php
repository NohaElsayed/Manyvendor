<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'productId'=>$this->productId,
            'name'=>Str::limit($this->name,14),
            'image'=>filePath($this->image),
            'slug'=>$this->slug,
            'sku'=>$this->sku,
            'discount'=>$this->discount,
            'discountHave'=>$this->discountHave,
            'price'=>$this->price,
        ];
    }
}

