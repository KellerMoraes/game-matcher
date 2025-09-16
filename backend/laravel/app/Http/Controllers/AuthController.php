<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(StoreUserRequest $request): JsonResponse
    {
    // StoreUserRequest talvez devesse ser substituido por um StoreAuthUserRequest seilá...
    $login = $this->authService->register($request->validated());
    return response()->json($login, 201);
    }

    public function login(Request $request): JsonResponse
    {
    // StoreUserRequest talvez devesse ser substituido por um StoreAuthUserRequest seilá... se tiver uma lógica mais especifica de login deveria ir para o request, ou se quiser deixar mais bonito
    $login = $this->authService->login($request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6'
    ]));
    if(!$login) return response()->json(['message' => 'Invalid Credentials!'], 401);
    return response()->json($login, 200);
    }

    public function logout(Request $request): JsonResponse
    {
        // 4|iOhNt53wLfRqXaYEfxa2h6yz5USAUK4rCLwCotgj275e915e
    // StoreUserRequest talvez devesse ser substituido por um StoreAuthUserRequest seilá...
    $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => "Loged Out"]);
    }

    public function me(Request $request): JsonResponse
    {
    // StoreUserRequest talvez devesse ser substituido por um StoreAuthUserRequest seilá...
    return response()->json($request->user());
    }
    
}
