<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EcommerceSingleProduct extends JsonResource
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
            'name'=>$this->name,
            'shortDesc'=>$this->shortDesc,
            'bigDesc'=>$this->bigDesc,
            'discountHave'=>$this->discountHave,
            'discount'=>$this->discount,
            'price'=>$this->price,
            'catName'=>$this->catName,
            'catId'=>$this->catId,
            'brand'=>$this->brand,
            'brandId'=>$this->brandId,
            'productStockId'=>$this->productStockId,
            'images'=>ImagesResource::collection($this->images),
            'variants'=>UnitResource::collection($this->variants),
        ];
    }
}
