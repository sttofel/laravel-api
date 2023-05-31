<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ComputerResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ComputerRequest;
use App\Http\Resources\DefaultComputerResource;
use App\Repositories\ComputerRepository;

class ComputerController extends Controller
{
    protected $repository;

    public function __construct(ComputerRepository $ComputerRepository){
        $this->repository = $ComputerRepository;
    }

    public function index(){
        return ComputerResource::collection($this->repository->getAllComputers());
    }

    public function show(String $id){
        return new ComputerResource($this->repository->getComputer($id));
    }

    public function store(ComputerRequest $request){
        $computerDetails = $request->only( 'reseller_id', 'customer_id', 'user_id', 'serial', 'end_date', 'review');
        return new ComputerResource($this->repository->createComputer($computerDetails));
    }

    public function update(String $id, ComputerRequest $request){
        $computerDetails = $request->only('reseller_id', 'customer_id', 'user_id', 'serial', 'start_date', 'end_date', 'review');
        return new ComputerResource($this->repository->updateComputer($computerDetails, $id));
    }

    public function destroy(String $id){
        return new DefaultComputerResource($this->repository->deleteComputer($id));
    }

    public function showBySerial(String $serial){
        return new DefaultComputerResource($this->repository->getComputerBySerial($serial));
    }
}
