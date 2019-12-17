<?php

namespace GraphTheory\Lab4;

require_once('Item.php');

Class Sets
{
    private $sets = [];

    public function __construct(array $weights, array $value)
    {
        foreach ($weights as $key => $weight) {
            $this->sets[] = new Item($weight, $value[$key], $key + 1);
        }
    }

    /** @return Item[] */
    public function getSets(): array
    {
        return $this->sets;
    }

    public function count(): int
    {
        return count($this->sets);
    }
}