<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class VendorProductResource extends JsonResource
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
            'productId'=>$this->product_id,
            'name'=>Str::limit($this->name,14),
            'image'=>$this->image,
            'slug'=>$this->slug,
            'sku'=>$this->sku,
            'discount'=>$this->discount,
            'discountHave'=>$this->discountHave,
            'price'=>$this->price
        ];
    }
}
