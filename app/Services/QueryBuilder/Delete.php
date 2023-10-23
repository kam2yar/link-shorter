<?php

namespace App\Services\QueryBuilder;

use App\Services\QueryBuilder\Interfaces\QueryInterface;

class Delete implements QueryInterface
{
    private string $table;

    private array $conditions = [];

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function __toString(): string
    {
        return 'DELETE FROM ' . $this->table . ($this->conditions === [] ? '' : ' WHERE ' . implode(' AND ', $this->conditions));
    }

    public function where(string ...$where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }
}
