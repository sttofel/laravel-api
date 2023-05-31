<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserRequestUpdate;
use App\Http\Resources\DefaultResource;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $repository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->repository = $UserRepository;
    }

    public function index()
    {
        return UserResource::collection($this->repository->getAllUsers());
    }

    public function show(String $id)
    {
        return new UserResource($this->repository->getUserById($id));
    }

    public function update(String $id, UserRequestUpdate $request)
    {
        $userDetails = $request->only('name', 'email', 'type', 'status');
        return new DefaultResource($this->repository->updateUser($userDetails, $id));
    }

    public function store(UserRequest $request)
    {
        $userDetails = $request->only('name', 'email', 'type', 'status', 'password', 'password_confirmation');

        if (!isset($userDetails['password'])){
            $userDetails['password'] = '12345678';
        }

        return new DefaultResource($this->repository->createUser($userDetails));
    }

    public function updatePassword(String $id, UserPasswordRequest $request){
        $userDetails = $request->only('password', 'password_confirmation');
        return new DefaultResource($this->repository->updatePasswordUser($userDetails, $id));
    }

    public function destroy(String $id)
    {
        return new DefaultResource($this->repository->deleteUser($id));
    }
}
