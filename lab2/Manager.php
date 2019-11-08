<?php

namespace GraphTheory\Lab2;

use GraphTheory\Lab1\Point;

require_once('PointSorter.php');

class Manager
{
    private $sorter;
    private $result = ['length' => 10000, 'pair' => []];
    private $pointsBetween = [];

    public function __construct()
    {
        $this->sorter = new \PointSorter();
    }

    public function calculate(array $data): array
    {
        // sortuje tablice  po X
        $Sx = $this->sorter->mergeSort($data);
        /** @var Point $point */
        foreach ($Sx as $key => $point) {
            $point->setPosition($key);
        }

        // sortuje tablice po Y
        $this->sorter->setMethod('y');
        $Sy = $this->sorter->mergeSort($Sx);

        // rekurencyjnie znajduje najblisze pary
        $this->getMinLengthPoint($data, $Sx, $Sy);
        $theBest = $this->result;

        $middle = (int)(count($data) / 2);

        //wyznaczam punkt srodkowy zbioru posortowanego po X
        /** @var Point $middlePoint */
        $middlePoint = $Sx[$middle];

        // wybieram punkty znajdujące sie pomiedzy srodkiem ograniczonym najlepszym dystansem +/-
        $pointsBetween = $this->findPointsBetweenMaxLength($Sy, $middlePoint);

        $left = [];
        $right = [];

        // dziele otrzymany zbior na lewy i prawy, aby wybierac kolejne punkty po przeciwnej stronie
        foreach ($pointsBetween as $point) {
            if ($middlePoint->getX() < $point->getX()) $left[$point->getPosition()] = $point;
            else $right[$point->getPosition()] = $point;
        }

        // sprawdzenie 4 kolejnych puntków, jeżeli jest krótszy niz wynik z poprzedniego wyniku to dodaje
        $leftCounter = 0;
        $rightCounter = 0;

        // jade posortowqanych puntków pokolei
        foreach ($pointsBetween as $point) {
            $sets = [];

            // sprawdzam punkt czy znajduje sie po lewej czy prawej stronie
            if (isset($left[$point->getPosition()])) {

                $sets[] = $right[$leftCounter + 1] ?? null;
                $sets[] = $right[$leftCounter + 2] ?? null;
                $sets[] = $right[$leftCounter + 3] ?? null;
                $sets[] = $right[$leftCounter + 4] ?? null;

                // sprawdzam odleglosci od 4 kolejnych punktów
                foreach ($sets as $current) {
                    if(!$current) continue;
                    $distance = $this->getLength($current, $point);
                    if ($distance < $theBest['length']) {
                        $theBest['length'] = $distance;
                        $theBest['pair'] = [$current, $point];
                    }
                }
                $leftCounter++;
            } else {
                $sets[] = $left[$rightCounter + 1] ?? null;
                $sets[] = $left[$rightCounter + 2] ?? null;
                $sets[] = $left[$rightCounter + 3] ?? null;
                $sets[] = $left[$rightCounter + 4] ?? null;

                foreach ($sets as $current) {
                    if(!$current) continue;
                    $distance = $this->getLength($current, $point);
                    if ($distance < $theBest['length']) {
                        $theBest['length'] = $distance;
                        $theBest['pair'] = [$current, $point];
                    }
                }
                $rightCounter++;
            }
        }
        return $theBest;
    }

    private function findPointsBetweenMaxLength(array $Sy, Point $middle): array
    {
        $min = $middle->getX() - $this->result['length'];
        $max = $middle->getX() + $this->result['length'];
        $result = [];
        foreach ($Sy as $point) {
            if ($min < $point->getX() && $point->getX() < $max) {
                $result[] = $point;
                $this->pointsBetween[] = $point->getPosition();
            }
        }
        return $result;
    }

    private function getMinLengthPoint(array $data, array $X, array $Y)
    {
        $counter = count($data);
        if ($counter == 2) return $this->getLength($X[0], $X[1]);
        $middle = (int)($counter / 2);

        $rightLength = $counter - $middle;
        $start = $middle;

        if ($counter % 2 !== 0) {
            $rightLength--;
            $start++;
        }

        $right = array_slice($data, $start, $rightLength);
        $left = array_slice($data, 0, $middle);

        $rightX = array_slice($X, $start, $rightLength);
        $leftX = array_slice($X, 0, $middle);

        $rightY = array_slice($Y, $start, $counter - $middle);
        $leftY = array_slice($Y, 0, $middle);
        $dL = $this->getMinLengthPoint($left, $leftX, $leftY);
        $dR = $this->getMinLengthPoint($right, $rightX, $rightY);

        if ($dL < $dR) return $this->checkLength($dL, $leftX);
        else return $this->checkLength($dR, $rightX);
    }

    public function checkLength(float $length, array $pair): float
    {
        if ($this->result['length'] > $length) {
            $this->result['pair'] = $pair;
            $this->result['length'] = $length;
        }
        return $length;
    }

    private function getLength(Point $p, Point $q): float
    {
        $x = pow(abs($p->getX() - $q->getX()), 2);
        $y = pow(abs($p->getY() - $q->getY()), 2);

        return pow($x + $y, 0.5);
    }
}