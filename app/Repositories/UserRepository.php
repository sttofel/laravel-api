<?php

namespace App\Repositories;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Auth;

class UserRepository{
  protected $entity;

  public function __construct(User $model){
    $this->entity = $model;
  }

  public function getAllUsers(){
    return $this->entity->get();
  }

  public function getUserById(String $identity){
    return $this->entity->findOrFail($identity);
  }

  public function createUser(array $attributes){
      return $this->entity->create(
          [
              'name' => $attributes['name'],
              'email' => $attributes['email'],
              'password' =>  bcrypt($attributes['password']),
              'type' => $attributes['type'],
              'status' => $attributes['status'],
          ]
      );
  }

  public function updateUser(array $attributes, string $identity){
      $user = $this->entity->findOrFail($identity);
      $user->name = $attributes['name'];
      $user->email = $attributes['email'];
      $user->type = $attributes['type'];
      $user->status = $attributes['status'];
      $status = $user->save();

      return ['message' => $status, 'user' => $user];
  }

    public function updatePasswordUser(array $attributes, string $identity){
      $user = $this->entity->findOrFail($identity);
      $user->password = bcrypt($attributes['password']);
      $status = $user->save();

      return ['message' => $status, 'user' => $user];
  }

  public function deleteUser(String $identity)
  {
    $user = $this->entity->findOrFail($identity);
    $status = $user->delete();
    return ['message' => $status];
  }

  public function getUserInfo(){
    return $this->entity->with('reseller')->findOrFail(auth()->user()->id);
  }
}
