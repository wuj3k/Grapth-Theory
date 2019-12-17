<?php

namespace GraphTheory\Lab4;

require_once('Sets.php');

class Manager
{
    private $data;
    /** @var Sets */
    private $sets;
    private $maxCapacity;
    private $currentCapacity = 0;
    /** @var Item */
    private $currentItem;
    private $searchValue;
    private $currentValue = 0;

    public function __construct(int $maxCapacity, int $searchValue)
    {
        $this->maxCapacity = $maxCapacity;
        $this->searchValue = $searchValue;
    }

    public function generateMaxValue(): string
    {
        $start = microtime(true);
        foreach ($this->sets->getSets() as $item) {
            $this->currentItem = $item;
            while ($this->currentCapacity <= $this->maxCapacity) {
                if ($item->getWeight() > $this->currentCapacity)
                    $this->fillArrayMax($this->getValueFromAboveMax());
                else {
                    $max = max($this->getValueFromAboveMax(), $this->getPrevItemMax());
                    $this->fillArrayMax($max);
                }
                $this->currentCapacity++;
            }
            $this->currentCapacity = 0;
        }
        $end = (microtime(true) - $start) * 1000;
        $response = 'Szukana wartość to: ' . $this->data[$this->currentItem->getId()][$this->maxCapacity] . PHP_EOL;
        return $response . 'Czas wykonywania algorytmu to:' . $end.PHP_EOL;
    }

    public function generateMinSizeBag(): string
    {
        $start = microtime(true);
        foreach ($this->sets->getSets() as $item) {
            $this->currentItem = $item;
            while ($this->currentValue <= $this->searchValue) {
                if ($item->getValue() > $this->currentValue)
                    $this->fillArrayMin($this->getValueFromAboveMin());
                else {
                    $min = min($this->getValueFromAboveMin(), $this->getPrevItemMin());
                    $this->fillArrayMin($min);
                }
                $this->currentValue++;
            }
            $this->currentValue = 0;
        }
        $end = (microtime(true) - $start) * 1000;
        $response = 'Szukana wartość to: ' . $this->data[$this->currentItem->getId()][$this->searchValue] . PHP_EOL;
        return $response . 'Czas wykonywania algorytmu to:' . $end;
    }

    public function setSets(array $weights, $values): self
    {
        $this->sets = new Sets($weights, $values);
        return $this;
    }

    private function getValueFromAboveMin(): float
    {
        if ($this->currentItem->isFirst() && $this->currentItem->getValue() == $this->currentValue) return $this->currentItem->getWeight();
        if (!$this->isExistPrevItem()) return INF;
        return $this->data[$this->currentItem->getPrevItem()][$this->currentValue];
    }

    private function getPrevItemMin(): float
    {
        if (!$this->isExistPrevItem()) return INF;
        return $this->data[$this->currentItem->getPrevItem()][$this->currentValue - $this->currentItem->getValue()] + $this->currentItem->getWeight();
    }

    private function getValueFromAboveMax(): int
    {
        if (!$this->isExistPrevItem()) return 0;
        return $this->data[$this->currentItem->getPrevItem()][$this->currentCapacity];
    }

    private function getPrevItemMax(): int
    {
        if (!$this->isExistPrevItem()) return $this->currentItem->getValue();
        return $this->data[$this->currentItem->getPrevItem()][$this->currentCapacity - $this->currentItem->getWeight()] + $this->currentItem->getValue();
    }

    private function fillArrayMax(int $value): self
    {
        $this->data[$this->currentItem->getId()][$this->currentCapacity] = $value;
        return $this;
    }

    private function fillArrayMin(float $value): self
    {
        $this->data[$this->currentItem->getId()][$this->currentValue] = $value;
        if (!$this->currentValue) $this->data[$this->currentItem->getId()][0] = 0;
        return $this;
    }

    private function isExistPrevItem(): bool
    {
        return isset($this->data[$this->currentItem->getPrevItem()]);
    }
}