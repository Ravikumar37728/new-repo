<?php

namespace App\Http\Resources;

use App\Models\Festival;
use Illuminate\Http\Resources\Json\JsonResource;

class CreativeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $festival = Festival::find($this->festival_id);

        return [
            'id'=>$this->id,
            'name' => $this->name,
            'festival' => $festival,
            'creative' => asset('storage/creatives/' . $this->creative),
        ];
    }
}
