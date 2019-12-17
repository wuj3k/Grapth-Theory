<?php

namespace GraphTheory\Lab3;

require_once('../lab2/PointSorter.php');
require_once('../lab3/SortedArray.php');
require_once('../lab3/Node.php');

use GraphTheory\Lab1\Point;

class KDTree
{
    private $sorter;

    public function __construct()
    {
        $this->sorter = new \PointSorter();
    }

    public function sortPoints(array $unSortedPoints): SortedArray
    {
        $Sx = $this->sorter->mergeSort($unSortedPoints);
        /** @var Point $point */
        foreach ($Sx as $key => $point) {
            $point->setPosition($key);
        }

        $this->sorter->setMethod('y');
        $Sy = [];
        foreach ($this->sorter->mergeSort($Sx) as $point) {
            $Sy[$point->getPosition()] = $point;
        }
        return new SortedArray($Sx, $Sy);
    }

    public function build(SortedArray $points, $depth = 0): Node
    {
        if ($points->isLast()) return (new Node())->setPoint($points->getPoint());
        else {
            $node = new Node();
            if ($depth % 2 == 0) {
                $result = $points->sliceByX();
                $node
                    ->setLine($result['left']->getLine('x'))
                    ->setDepth($depth);
            } else {
                $result = $points->sliceByY();
                $node
                    ->setLine($result['left']->getLine('y'))
                    ->setDepth($depth);
            }

            $leftSon = $this->build($result['left'], $depth + 1);
            if ($result['right']->count() > 0) $rightSon = $this->build($result['right'], $depth + 1);

            $node->setLeftChild($leftSon);
            if (isset($rightSon)) $node->setRightChild($rightSon);
            return $node;
        }
    }
}