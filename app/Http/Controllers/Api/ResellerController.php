<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResellerRequest;
use App\Http\Resources\ResellerResource;
use App\Repositories\ResellerRepository;
use Illuminate\Http\Request;

class ResellerController extends Controller
{
    public function __construct(ResellerRepository $resellerRepository){
        $this->repository = $resellerRepository;
    }

    public function index(){
        return ResellerResource::collection($this->repository->getAllResellers());
    }

    public function show(String $id){
       return new ResellerResource($this->repository->getResellerById($id));
    }

    public function update(String $id, ResellerRequest $request){
        $resellerDetails = $request->only('user_id', 'company_name', 'document');
        return new ResellerResource($this->repository->updateReseller($resellerDetails, $id));
    }

    public function store(ResellerRequest $request){
        $resellerDetails = $request->only('user_id', 'company_name', 'document');
        return new ResellerResource($this->repository->createReseller($resellerDetails));
    }

    public function destroy(String $id){
        return new ResellerResource($this->repository->deleteReseller($id));
    }
}
