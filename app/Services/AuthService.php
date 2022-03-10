<?php

namespace App\Services;

use App\Exceptions\CustomException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService {
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(object $input){
        $checkAuth = auth()->attempt([
            'email' => $input->email,
            'password' => $input->password
        ]);

        if($checkAuth){
            $user = $this->user->where('email', $input->email)->first();
            $success['user'] = $user;
            $success['token'] =  $user->createToken("Access Token")->plainTextToken;
            // $success['token_type'] = "Bearer";
            return $success;
        } else {
            throw new CustomException("Invalid email or password.");
        }
    }

    public function signup(object $input){

        $user = User::create([
            'name' => $input->name,
            'email' => $input->email,
            'password' => Hash::make($input->password),
            'password_view' => $input->password,
            'is_active' => isset(User::STATUS['ACTIVE']) ? User::STATUS['ACTIVE'] : 0,
            'role' => User::USER_ROLE,
        ]);

        $success['user'] = $user;
        $success['token'] =  $user->createToken("Access Token")->plainTextToken;
        $success['token_type'] = "Bearer";

        return $success;
    }

}