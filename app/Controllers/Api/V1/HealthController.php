<?php

namespace App\Controllers\Api\V1;

class HealthController
{
    public function ping(): void
    {
        response()->json([
            'message' => 'pong'
        ]);
    }
}