<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function auth(AuthRequest $request){
        $user = User::where('email', $request->email)->first();
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $user->tokens()->delete();
        if ($user->status == 0){
            $user->tokens()->delete();
            return response()->json(['message' => 'This account is locked to sign on.'], 400);
        }
        $token = $user->createToken($request->device_name)->plainTextToken;
        return response()->json(['token' => $token]);
    }

    public function me(){
       $user = User::with('reseller')->find(auth()->user()->id);
       return new UserResource($user);    }

    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json(['logout' => true]);
    }
}
