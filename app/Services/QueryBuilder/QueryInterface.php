<?php

namespace App\Services\QueryBuilder;

interface QueryInterface
{
    public function __toString(): string;
}