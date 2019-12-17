<?php

use GraphTheory\Lab1\Loader;

require_once('../lab3/KDTree.php');
require_once('../lab1/Loader.php');

$data = Loader::load('result.csv');

$manager = new \GraphTheory\Lab3\KDTree();
$x = $manager->build($manager->sortPoints($data));
$r = 1;
