<?php

namespace GraphTheory\Lab3;

use GraphTheory\Lab1\Point;

class SortedArray
{
    /** @var Point[] $point */
    private $x;
    /** @var Point[] $point */
    private $y;

    public function __construct(array $x, array $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function sliceByX(): array
    {
        $leftArray = array_slice($this->x, 0, $this->getMedian(), true);
        $rightArray = array_slice($this->x, $this->getMedian(), null, true);
        return ['left' => new SortedArray($leftArray, $this->getY($leftArray)), 'right' => new SortedArray($rightArray, $this->getY($rightArray))];
    }

    public function sliceByY(): array
    {
        $leftArray = array_slice($this->y, 0, $this->getMedian(), true);
        $rightArray = array_slice($this->y, $this->getMedian(), null , true);
        return ['left' => new SortedArray($leftArray, $this->getX($leftArray)), 'right' => new SortedArray($rightArray, $this->getX($rightArray))];
    }

    private function getY(array $data)
    {
        $result = [];
        $keys = array_keys($data);
        foreach ($this->y as $point){
            if(in_array($point->getPosition(), $keys)) $result[$point->getPosition()] = $point;
        }
        return $result;
    }

    private function getX(array $data)
    {
        $result = [];
        $keys = array_keys($data);
        foreach ($this->x as $point){
            if(in_array($point->getPosition(), $keys)) $result[$point->getPosition()] = $point;
        }
        return $result;
    }

    public function getMedian(): int
    {
        return floor(count($this->x) / 2);
    }

    public function isLast(): bool
    {
        return count($this->x) == 1;
    }

    public function count(): int
    {
        return count($this->x);
    }
    public function getPoint(): Point
    {
        $key = array_keys($this->x);
        return $this->x[$key[0]];
    }

    public function getLine(string $cords)
    {
        $keys = array_keys($this->$cords);
        $index = $keys[count($keys) - 1];
        return $this->$cords[$index];
    }
}