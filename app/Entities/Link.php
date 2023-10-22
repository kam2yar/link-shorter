<?php

namespace App\Entities;

class Link
{
    public string $table = 'links';

    private int $id;

    private string $long;

    private string $short;

    public function getId(): int
    {
        return $this->id;
    }

    public function getLong(): string
    {
        return $this->long;
    }

    public function setLong(string $long): self
    {
        $this->long = $long;
        return $this;
    }

    public function getShort(): string
    {
        return $this->short;
    }

    public function setShort(string $short): self
    {
        $this->short = $short;
        return $this;
    }
}