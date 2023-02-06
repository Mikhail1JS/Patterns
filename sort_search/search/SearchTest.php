<?php

include '../sort/randArray.php';
include 'LinearSearch.php';
include 'BinarySearch.php';
include 'InterpolationSearch.php';

const NUM = 5000;

$arr = getSortRandArray();

//print_r($arr);

echo "Линейный поиск".PHP_EOL;
echo SearchTest . phplinearSearch($arr, NUM) . PHP_EOL;

echo "Бинарный поиск".PHP_EOL;
echo SearchTest . phpbinarySearch($arr, NUM) . PHP_EOL;

echo "Интерполяционный".PHP_EOL;
echo interpolationSearch($arr, NUM);
