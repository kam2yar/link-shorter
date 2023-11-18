<?php

namespace App\Middlewares;

use App\Repositories\UserRepository;
use Pecee\Http\Middleware\IMiddleware;
use Pecee\Http\Request;

class PermissionMiddleware implements IMiddleware
{
    public function handle(Request $request): void
    {
        $userId = $_SESSION['userId'] ?? null;

        if (!$userId) {
            $this->accessDenied();
        }

        $userRepository = new UserRepository();
        $user = $userRepository->find($userId);

        if (empty($user)) {
            $this->accessDenied();
        }

        if (!$user['is_admin']) {
            $this->accessDenied();
        }
    }

    public function accessDenied(): void
    {
        response()->httpCode(403)->json([
            'success' => false,
            'message' => 'Access denied'
        ]);
    }
}