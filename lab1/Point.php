<?php

namespace GraphTheory\Lab1;

class Point
{
    private $x;
    private $y;
    private $position;

    public function __construct(array $data, int $position = 0)
    {
        $this->x = $data[0];
        $this->y = $data[1];
        $this->position = $position;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function setY(int $y)
    {
        $this->y = $y;
    }

    public function __toString(): string
    {
        return "Punkt o Id : {$this->getPosition()}" . PHP_EOL . " X : {$this->getX()}" . PHP_EOL . " Y : {$this->getY()}" . PHP_EOL;
    }
}