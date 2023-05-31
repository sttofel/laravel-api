<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class CustomerRepository
{
    protected $entity;


    public function __construct(Customer $model){
        $this->entity = $model;
    }

    public function getAllCustomers(){
       return $this->entity->get();
    }

    public function getCustomer(string $identity){
        return $this->entity->findOrFail($identity);
    }

    public function createCustomer(array $attributes){
        return $this->entity->create($attributes);

    }

    public function updateCustomer(array $attributes, String $identity){
        $customer = $this->entity->find($identity);
        $customer->user_id =$attributes['user_id'];
        $customer->reseller_id =$attributes['reseller_id'];
        $customer->name=$attributes['name'];
        $customer->cnpj=$attributes['cnpj'];
        $success = $customer->save();
        return ['success' => $success, 'customer' => $customer];
    }

    public function deleteCustomer(String $identity){
        $customer = $this->entity->findOrFail($identity);
        $success = $customer->delete();
       return ['success' => $success];
    }

}
