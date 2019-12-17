<?php

namespace GraphTheory\Lab3;

use GraphTheory\Lab1\Point;

class Node
{
    protected $rightChild;
    protected $leftChild;
    protected $point;
    protected $line;
    protected $depth;

    public function getPoint(): Point
    {
        return $this->point;
    }

    public function setPoint(Point $point): self
    {
        $this->point = $point;
        return $this;
    }

    public function getRightChild(): Node
    {
        return $this->rightChild;
    }

    public function setRightChild(Node $rightChild): self
    {
        $this->rightChild = $rightChild;
        return $this;
    }

    public function getLeftChild(): Node
    {
        return $this->leftChild;
    }

    public function setLeftChild(Node $leftChild): self
    {
        $this->leftChild = $leftChild;
        return $this;
    }

    public function setLine(Point $point): Node
    {
        $this->line = $point;
        return $this;
    }

    public function setDepth($depth): void
    {
        $this->depth = $depth;
    }

    public function isHorizontal(): bool
    {
        if($this->depth % 2 == 0) return true;
        else false;
    }

    public function isLeaf(): bool
    {
        return $this->leftChild || $this->rightChild;
    }
}