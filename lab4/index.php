<?php

require_once ('Manager.php');
//$weights = [6, 3, 4, 2];
//$values = [5, 1, 4, 2];
$weights = [6,7,6,9,7,30];
$values = [2,5,4,3,1,16];

$weights2 = [6,7,6,9,7,30];
$values2= [3,5,4,3,2,16];
$manager = new \GraphTheory\Lab4\Manager(35, 17);
echo $manager
    ->setSets($weights,$values)
    ->generateMaxValue();

echo $manager
    ->setSets($weights,$values)
    ->generateMinSizeBag();
