<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EanResource extends JsonResource
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
        return parent::toArray($request);
    }
}
