<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Controller;
use App\Entities\User;
use App\Repositories\UserRepository;
use App\Services\Auth\JwtHandler;

class AuthController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();

        $this->userRepository = new UserRepository();
    }

    public function register(): void
    {
        $user = new User();
        $user->email = input('email');
        $user->password = password_hash(input('password'), PASSWORD_BCRYPT);
        $user->createdAt = now();

        $this->userRepository->insert($user);

        response()->httpCode(201)->json([
            'success' => true,
            'message' => 'User created successfully, you can login now'
        ]);
    }

    public function login(): void
    {
        $user = $this->userRepository->find(input('email'), 'email');

        if (!$user) {
            response()->httpCode(422)->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        if (!password_verify(input('password'), $user['password'])) {
            response()->httpCode(401)->json([
                'success' => false,
                'message' => 'Incorrect password'
            ]);
        }

        $token = (new JwtHandler())->encodeToken($user['id']);

        response()->httpCode(201)->json([
            'success' => true,
            'message' => 'Successful login',
            'token' => $token
        ]);
    }
}