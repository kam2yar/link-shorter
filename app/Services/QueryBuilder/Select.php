<?php

namespace App\Services\QueryBuilder;

class Select implements QueryInterface
{
    private array $fields = [];

    private array $conditions = [];

    private array $order = [];

    private array $from = [];

    private array $innerJoin = [];

    private array $leftJoin = [];

    private ?int $limit = null;

    public function __construct(array $select)
    {
        $this->fields = $select;
    }

    public function select(string ...$select): self
    {
        foreach ($select as $arg) {
            $this->fields[] = $arg;
        }
        return $this;
    }

    public function __toString(): string
    {
        $fields = array_map(function ($item) {
            return '`' . $item . '`';
        }, $this->fields);

        $conditions = array_map(function ($item) {
            return '`' . $item . '`';
        }, $this->conditions);

        return 'SELECT ' . implode(', ', $fields)
            . ' FROM ' . implode(', ', $this->from)
            . ($this->leftJoin === [] ? '' : ' LEFT JOIN ' . implode(' LEFT JOIN ', $this->leftJoin))
            . ($this->innerJoin === [] ? '' : ' INNER JOIN ' . implode(' INNER JOIN ', $this->innerJoin))
            . ($this->conditions === [] ? '' : ' WHERE ' . implode(' AND ', $conditions))
            . ($this->order === [] ? '' : ' ORDER BY ' . implode(', ', $this->order))
            . ($this->limit === null ? '' : ' LIMIT ' . $this->limit);
    }

    public function where(string ...$where): self
    {
        foreach ($where as $arg) {
            $this->conditions[] = $arg;
        }
        return $this;
    }

    public function from(string $table, ?string $alias = null): self
    {
        $this->from[] = $alias === null ? $table : "{$table} AS {$alias}";
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function orderBy(string ...$order): self
    {
        foreach ($order as $arg) {
            $this->order[] = $arg;
        }
        return $this;
    }

    public function innerJoin(string ...$join): self
    {
        $this->leftJoin = [];
        foreach ($join as $arg) {
            $this->innerJoin[] = $arg;
        }
        return $this;
    }

    public function leftJoin(string ...$join): self
    {
        $this->innerJoin = [];
        foreach ($join as $arg) {
            $this->leftJoin[] = $arg;
        }
        return $this;
    }
}
