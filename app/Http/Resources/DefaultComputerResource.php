<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DefaultComputerResource extends JsonResource
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
        //return parent::toArray($request);
        return [
            'SERIALHD' => $this->serial,
            'OBS' => $this->review,
            'DATA_INICIAL' => $this->start_date,
            'DATA_FINAL' => $this->end_date,
            'LIBERADO' => $this->status,
            'REVENDA' => ResellerResource::collection($this->reseller_id)
        ];
    }
}
