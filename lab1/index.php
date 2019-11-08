<?php
require_once ('Point.php');

$manager = new Manager(Loader::load());
$result = $manager->calculate();
$printer = new Printer();
$printer
    ->setCoordinates($result)
    ->print();

/** logika
 *  ogolnie przyjełem założenie że punkt znajdujący sie na prawo znajduje sie poniżej,
 *  podwarunkiem że nie znajduje się w tej samej lini na osi X ( Warunek nr 1 ).
 * Jądro istnieje wtedy kiedy pozioma górna pozioma jądra jest większa niz dolna ( Warunek 2)
 */
class Manager
{
    /**
     * Linia pozioma jądrą dolna
     * @var Point
     */
    private $maxTop;
    /**
     * @var Point
     * Linia pozioma jądrą dolna
     */
    private $minTop;
    /**
     * punkty znajdujące się poniżej jądra
     */
    private $bottom = [];
    /**
     * punkty znajdujące się powyżej jądra
     */
    private $top = [];
    private $isTop = true;
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function calculate(): array
    {
        $round = 0;
        $temp = [];
        $data = $this->data;
        $this->top[] = $data[0];
        $this->minTop = $data[1];
        /** @var Point[] $data */
        foreach ($this->data as $item) {
            if ($round > (count($data) - 3)) break;
            $this->isTop ? $this->top[] = $data[$round + 2] : $this->bottom[] = $data[$round + 2];

            /** warunek na zamiane kierunku */
            if (isset($data[$round + 3]) && $data[$round + 2]->getX() > $data[$round + 3]->getX() && $this->isTop) {
                if (!$round) $this->minTop = $item;
                $round++;
                $this->isTop = false;
                $this->bottom[] = $data[$round + 2];
                continue;
            }
            //TODO Twoje macierz trzech punktów
            $temp[] = $item;
            $temp[] = $data[$round + 1];
            $temp[] = $data[$round + 2];

            $det = $this->calculateDet($temp); // TODO wyliczanie wyznacznika regułą Sarrusa
            if ($det < 0) {
                if ($this->isTop) {
                    if ($item->getX() !== $data[$round + 1]->getX()) $this->minTop = $data[$round + 2]; // TODO Warunek nr 1
                } else {
                    if ($item->getX() !== $data[$round + 1]->getX()) $this->maxTop = $data[$round + 2]; // TODO Warunek nr 1
                }
            }
            $round++;
            $temp = [];
        }
        /** sprawdzam czy sąsiednie punktu min i max są na tym samym poziomie, jak są to usuwam jeden */
        //if (count($this->top) !== 2) $this->checkTheSameLevel($this->minTop);
        //if (count($this->bottom) !== 2) $this->checkTheSameLevel($this->maxTop);

        /** ( Warunek 2) */
        $this->maxTop ?: $this->maxTop = new Point([0, 0], 100);
        if ($this->minTop->getY() - $this->maxTop->getY() >= 0) echo 'Wielokąt ma jądro, dolna belka JĄDRA znajduję się na ' . $this->maxTop->getY() . 'a górna na ' . $this->minTop->getY();
        else echo 'Wielokąt nie ma jądra';
        return $this->data;
    }

    public function calculateDet(array $matrix): int
    {
        return $matrix[0]->getX() * $matrix[1]->getY() + $matrix[1]->getX() * $matrix[2]->getY() + $matrix[2]->getX() * $matrix[0]->getY() -
            $matrix[2]->getX() * $matrix[1]->getY() - $matrix[0]->getX() * $matrix[2]->getY() - $matrix[1]->getX() * $matrix[0]->getY();
    }

    private function checkTheSameLevel(Point $point)
    {
        if (isset($this->data[$point->getPosition() - 1]) && $point->getY() == $this->data[$point->getPosition() - 1]->getY()) unset($this->data[$point->getPosition() - 1]);
        if (isset($this->data[$point->getPosition() + 1]) && $point->getY() == $this->data[$point->getPosition() + 1]->getY()) unset($this->data[$point->getPosition() + 1]);
    }
}

/** Rysuje wielokąt */
class Printer
{
    private $coordinates = [];
    private $image;

    public function __construct()
    {
        $this->image = imagecreate(1000, 1000);
    }

    public function print(): void
    {
        $this->getSettings();
        //header('Content-type: image/png');
        imagepng($this->image, 'result2');
    }

    private function getSettings(): void
    {
        $bg = imagecolorallocate($this->image, 0, 0, 0);
        $blue = imagecolorallocate($this->image, 0, 0, 255);
        imagefilledrectangle($this->image, 0, 0, 249, 249, $bg);
        imagefilledpolygon($this->image, $this->getCoordinates(), count($this->getCoordinates()) / 2, $blue);
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    public function setCoordinates(array $coordinates): self
    {
        $result = [];
        foreach ($coordinates as $coordinate) {
            $result[] = $coordinate->getX() * 100;
            $result[] = 1000 - ($coordinate->getY() * 100);
        }
        $this->coordinates = $result;
        return $this;
    }
}

/** Laduje dane z pliku csv, struktura to x,y w jednej lini. np
 *  1,5
 *  6,4
 *  5,1
 *  3,3
 *  2,1
 */
class Loader
{
    static public function load(): array
    {
        $csvFile = file('result2.csv');
        $data = [];
        foreach ($csvFile as $key => $line) {
            $data[$key] = new Point(str_getcsv($line), $key);
        }
        return $data;
    }
}

