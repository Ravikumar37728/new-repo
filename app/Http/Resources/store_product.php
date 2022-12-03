<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class store_product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id'=>$this->id,
            'name' => $this->name,

            'short_desc' => $this->short_desc,
            'desc' => $this->desc,
            'product_image' => asset('storage/images/' . $this->product_image),
            'product_video' => asset('storage/videos/' . $this->product_video),
            'price' => $this->price,
        ];
    }
}
