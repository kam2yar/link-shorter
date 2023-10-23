<?php

namespace App\Services\QueryBuilder;

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
        $conditions = array_map(function ($item) {
            return '`' . $item . '`';
        }, $this->conditions);

        return 'DELETE FROM ' . $this->table . ($this->conditions === [] ? '' : ' WHERE ' . implode(' AND ', $conditions));
    }

    public function where(string ...$where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }

        return $this;
    }
}
