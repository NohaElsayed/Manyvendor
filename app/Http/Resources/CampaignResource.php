<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
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
            'title'=>$this->title,
            'banner'=>filePath($this->banner),
            'offer'=>$this->offer,
            'start_from'=>date('d-m-yy',strtotime($this->start_from)),
            'end_at'=>date('d-m-yy',strtotime($this->end_at)),
        ];
    }
}
