<?php

namespace App\Controllers;

class Controller
{
    protected ?int $userId = null;

    public function __construct()
    {
        $this->userId = $_SESSION['userId'] ?? null;
    }
}