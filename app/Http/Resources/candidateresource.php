<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class candidateresource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
                'firstname'=>$this->firstname,
                'lastname'=>$this->lastname,
                'email'=>$this->email,
                'phoneno'=>$this->phoneno,
                'position'=>$this->position,
                'work_experience'=>$this->work_experience,
                'current_ctc'=>$this->current_ctc,
                'location'=>$this->location,
                'address'=>$this->address,
                'messages'=>$this->messages,
                'resume'=> asset('storage/resumes/' . $this->resume), 
        ];
    }
}
