<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TrendingCategoryResource extends JsonResource
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
            'catId'=>$this->id,
            'name'=>$this->name,
            'image' =>$this->image == null ? filePath('comparison.png') : filePath($this->image)
        ];
    }
}
