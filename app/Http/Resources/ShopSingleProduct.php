<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopSingleProduct extends JsonResource
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
            'images'=>ImagesResource::collection($this->images),
            'variants'=>UnitResource::collection($this->variants),
            'forCart'=>ForSaleProduct::collection($this->shops)

        ];
    }
}

class ImagesResource extends JsonResource{
    public function toArray($request)
    {
        return [
            'url'=>$this->url
        ];
    }
}


class UnitResource extends JsonResource{
    public function toArray($request)
    {
        return [
            'unit'=>$this->unit,
            'variant'=>VariantResource::collection($this->variant),
        ];
    }
}

class VariantResource extends JsonResource{
    public function toArray($request)
    {
        return [
            'variantId'=>$this->variantId,
            'unit'=>$this->unit,
            'active'=>false,
            'variant'=>$this->variant,
            'code'=>$this->code,
        ];
    }
}

class ForSaleProduct extends JsonResource{
    public function toArray($request)
    {
        return [
            'name'=>$this->name,
            'email'=>$this->email,
            'vendorId'=>$this->vendorId,
            'rating'=>$this->rating,
            'stockOut'=>$this->stockOut,
            'discountText'=>$this->discountText,
            'priceFormat'=>$this->priceFormat,
            'price'=>$this->price,
            'extraPriceFormat'=>$this->extraPriceFormat,
            'extraPrice'=>$this->extraPrice,
            'totalPriceFormat'=>$this->totalPriceFormat,
            'totalPrice'=>$this->totalPrice,
            'shopLogo'=>$this->shopLogo,
            'slug'=>$this->slug,
            'vendorStockId'=>$this->vendorStockId,
            'variant'=>$this->variant,
        ];
    }
}
