<?php


namespace GraphTheory\Lab1;

require_once('Point.php');

class Loader
{
    static public function load(string $fileName): array
    {
        $csvFile = file($fileName);
        $data = [];
        foreach ($csvFile as $line) {
            $data[] = new Point(str_getcsv($line));
        }
        return $data;
    }
}