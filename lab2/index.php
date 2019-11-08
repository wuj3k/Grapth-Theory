<?php

use GraphTheory\Lab1\Loader;
use GraphTheory\Lab1\Point;

require_once('../lab1/Point.php');
require_once('../lab1/Loader.php');
require_once('../lab2/Manager.php');

$number = 10;
$data = [];
//while ($number > 0) {
//    $data[] = new Point([rand(1, 100), rand(1, 100)]);
//    $number--;
//}

$data = Loader::load('result.csv');

$manager = new \GraphTheory\Lab2\Manager();
$result = $manager->calculate($data);
$one = $result['pair'][0];
$two = $result['pair'][1];
echo "Para najbliszych punktów to :" . PHP_EOL . " {$one} oraz " . PHP_EOL . "{$two} a ich dystans to: {$result['length']}";

