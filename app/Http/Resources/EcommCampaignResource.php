<?php

namespace App\Http\Resources;

use App\EcomProductVariantStock;
use Illuminate\Http\Resources\Json\JsonResource;

class EcommCampaignResource extends JsonResource
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
            'productId'=>$this->id,
            'image'=>$this->image,
            'name'=>$this->name,
            'campaignId'=>$this->campaign_id,
            'stockOut'=>$this->stockOut,
            'variantStockId'=>$this->variant_stock_id,
            'price'=>$this->price,
            'variants'=>EcomeCampaignProductResource::collection($this->variants)
        ];
    }
}


class EcomeCampaignProductResource extends JsonResource{

    public function toArray($request)
    {
        return [
            'stockOut'=>$this->stockOut,
            'discountText'=>$this->discountText,
            'priceFormat'=>$this->priceFormat,
            'price'=>$this->price,
            'extraPriceFormat'=>$this->extraPriceFormat,
            'extraPrice'=>$this->extraPrice,
            'totalPriceFormat'=>$this->totalPriceFormat,
            'totalPrice'=>$this->totalPrice,
            'stockId'=>$this->stockId,
            'variant'=>$this->variant
        ];
    }
}