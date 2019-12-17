<?php

namespace GraphTheory\Lab4;

Class Item
{
    private $weight;
    private $value;
    private $id;

    public function __construct(int $weight, int $value, int $id)
    {
        $this->weight = $weight;
        $this->value = $value;
        $this->id = $id;
    }

    public function getWeight(): int
    {
        return $this->weight;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getPrevItem(): int
    {
        return $this->id - 1;
    }

    public function isFirst(): bool
    {
        return $this->id === 1;
    }
}