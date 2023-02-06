<?php
const COUNT = 1000;
const MIN_RAND = 1;
const MAX_RAND = 3000;


function _randArray($count = COUNT, $minRand = MIN_RAND, $maxRand = MAX_RAND)
{
    if ($count != COUNT && $count > $maxRand - $minRand) {
        $minRand = 1;
        $maxRand = $count * 3;
    }
    $myArray = [];
    for ($i = 0; $i < $count; $i++) {
        $num = mt_rand($minRand, $maxRand);
        $myArray[] = $num;
    }
    return $myArray;
}
