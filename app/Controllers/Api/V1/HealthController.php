<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Controller;

class HealthController extends Controller
{
    public function ping(): void
    {
        response()->json([
            'message' => 'pong'
        ]);
    }
}