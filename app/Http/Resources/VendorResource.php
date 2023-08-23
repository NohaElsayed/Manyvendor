<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
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
            'id'=>$this->id,
            'name'=>$this->name ?? '',
            'vendorId'=>$this->vendor->id,
            'shopLogo'=>filePath($this->vendor->shop_logo),
            'shopName'=>$this->vendor->shop_name ?? '',
            'phone'=>$this->phone ?? '',
            'address'=>$this->address ?? '',
            'about'=>$this->about ?? '',
            'facebook'=>$this->facebook ?? '',
            'totalProduct'=>$this->productCount->count(),
            'rating'=>shopRating($this->vendor->id)
        ];
    }
}
