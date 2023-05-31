<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    protected $repository;


    public function __construct(CustomerRepository $customerRepository){
        $this->repository = $customerRepository;
    }

    public function index(){
        return CustomerResource::collection($this->repository->getAllCustomers());
    }

    public function show(String $id){
        return new CustomerResource($this->repository->getCustomer($id));
    }

    public function store(CustomerRequest $request){
        $customerDetails = $request->only(['reseller_id', 'user_id', 'name', 'document']);

        return new CustomerResource($this->repository->createCustomer($customerDetails));
    }



    public function update(String $id, CustomerRequest $request){
        $customerDetails = $request->only(['reseller_id', 'user_id', 'name', 'document']);
        return new CustomerResource($this->repository->updateCustomer($customerDetails, $id));
    }


    public function destroy(String $id){
        return new CustomerResource($this->repository->deleteCustomer($id));
    }
}
