<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShopCampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'productId' => $this->product_id,
            'image' => $this->image,
            'name' => $this->name,
            'campaignId' => $this->campaign_id,
            'quantity' => $this->quantity,
            'vendorStockId' => $this->variant_stock_id,
            'stockOut' => $this->stockOut,
            'price' => $this->price,
            'rating' => $this->rating,
            'shopName' => $this->shop_name,
            'shops' => VariantCampaignResource::collection($this->shops)
        ];
    }
}


class VariantCampaignResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'vendorId' => $this->vendorId,
            'stockOut' => $this->stockOut,
            'discountText' => $this->discountText,
            'priceFormat' => $this->priceFormat,
            'price' => $this->price,
            'extraPriceFormat' => $this->extraPriceFormat,
            'extraPrice' => $this->extraPrice,
            'totalPriceFormat' => $this->totalPriceFormat,
            'totalPrice' => $this->totalPrice,
            'shopLogo' => $this->shopLogo,
            'vendorStockId' => $this->vendorStockId,
            'variant' => $this->variant,
        ];
    }
}

