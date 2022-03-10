<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\Login as LoginRequest;
use App\Http\Requests\Auth\SignUp as SignUpResuest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    private $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request){

        $data = $this->authService->login((object) $request->validated());
        return $this->success($data, 200);
    }

    public function signup(SignUpResuest $request){
        $data = $this->authService->signup((object) $request->validated());
        return $this->success($data, 200);
    }
}
