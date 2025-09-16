<?php
namespace App\Services;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Repositories\AuthRepository;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    private AuthRepository $authRepository;
 
    
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
     public function register(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->authRepository->register($data);
        return [
            'user' => $user, 
            'token' => $user->createToken('auth_token')->plainTextToken];

    }
     public function login(array $data): JsonResponse
     {
  
        $user = User::where('email', $data['email'])->first();
        if(!$user || !Hash::check($data['password'],$user->password )){
            return response()->json(['message' => 'Invalid Credentials!'], 401);   
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        
        return response()->json(
            ['user' => $user, 'token' => $token]
        ); 
    }
}