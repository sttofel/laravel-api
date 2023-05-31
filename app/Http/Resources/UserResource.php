<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $request->headers->set('Accept', 'application/json');
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'permission' => $this->type,
            'reseller' => ResellerResource::make($this->whenLoaded('reseller')),
        ];
    }
}
