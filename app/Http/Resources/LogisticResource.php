<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LogisticResource extends JsonResource
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
            'rate'=>$this->rate +(.0001),
            'id' =>$this->id,
            'name'=>$this->name,
            'days'=>$this->days,
        ];
    }
}
