<?php

namespace App\Repositories;

use App\Models\Reseller;

/**
 * Class ResellerRepository.
 */
class ResellerRepository
{
    protected $entity;

    public function __construct(Reseller $entity){
        $this->entity = $entity;
    }

    public function getAllResellers(){
        return $this->entity->get();
    }

    public function getResellerById(String $identity){
        return $this->entity->findOrFail($identity);
    }

    public function createReseller(array $attributes){
        return $this->entity->create([
            'user_id' => $attributes['user_id'],
            'company_name' => $attributes['company_name'],
            'document' => $attributes['document'],
        ]);
    }

    public function updateReseller(array $attributes, String $identity){
        $reseller = $this->entity->findOrFail($identity);
        $reseller->user_id = $attributes['user_id'];
        $reseller->company_name = $attributes['company_name'];
        $reseller->document = $attributes['document'];

        $status = $reseller->save();
        return ['message' => $status, 'user' => $reseller];
    }

    public function deleteReseller(String $identity)
    {
        $reseller = $this->entity->findOrFail($identity);
        $status = $reseller->delete();
        return ['message' => $status];
    }


}
