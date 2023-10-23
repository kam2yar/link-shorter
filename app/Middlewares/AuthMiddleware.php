<?php

namespace App\Middlewares;

use App\Repositories\UserRepository;
use App\Services\Auth\JwtHandler;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class AuthMiddleware implements IMiddleware
{
    public function handle(Request $request): void
    {

        $token = getallheaders()['Authorization'] ?? null;

        if (!$token) {
            return;
        }

        if (!preg_match('/Bearer\s(\S+)/', $token, $matches)) {
            $this->invalidToken();
        }


        $data = (new JwtHandler())->decodeToken($matches[1]);
        if (!is_integer($data)) {
            $this->invalidToken();
        }

        $userRepository = new UserRepository();
        $user = $userRepository->find($data);

        if (empty($user)) {
            $this->invalidToken();
        }

        $_SESSION['userId'] = $user['id'];
    }

    public function invalidToken(): void
    {
        unset($_SESSION['userId']);
        
        response()->httpCode(403)->json([
            'success' => false,
            'message' => 'Invalid token'
        ]);
    }
}