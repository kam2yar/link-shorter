<?php

namespace App\Services\Auth;

use App\Entities\User;
use App\Repositories\UserRepository;

class AuthService
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function register(string $email, string $password): bool
    {
        $user = new User();
        $user->email = input('email');
        $user->password = password_hash(input('password'), PASSWORD_BCRYPT);
        $user->createdAt = now();

        return $this->userRepository->insert($user);
    }

    public function login(string $email, string $password): string
    {
        $user = $this->userRepository->find($email, 'email');

        if (!$user) {
            response()->httpCode(422)->json([
                'success' => false,
                'message' => 'User not found'
            ]);
        }

        if (!password_verify($password, $user['password'])) {
            response()->httpCode(401)->json([
                'success' => false,
                'message' => 'Incorrect password'
            ]);
        }

        return (new JwtHandler())->encodeToken($user['id']);
    }
}