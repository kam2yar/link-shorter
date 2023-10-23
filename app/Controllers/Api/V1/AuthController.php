<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Controller;
use App\Services\Auth\AuthService;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct()
    {
        parent::__construct();

        $this->authService = new AuthService();
    }

    public function register(): void
    {
        $this->validator->validate(input()->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        $success = $this->authService->register(input('email'), input('password'));

        response()->httpCode(201)->json([
            'success' => $success,
            'message' => 'User created successfully, you can login now'
        ]);
    }

    public function login(): void
    {
        $this->validator->validate(input()->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $token = $this->authService->login(input('email'), input('password'));

        response()->httpCode(201)->json([
            'success' => true,
            'message' => 'Successful login',
            'token' => $token
        ]);
    }
}