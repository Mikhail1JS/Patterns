<?php
include 'BinarySearch.php';
include 'randArray.php';


const FIND_ELEMENT = 302;

$arr = getSortRandArray(10000);

$counter = 0;
$deleteElements = [];

for ($i = 0; $i <= $counter; $i++){
    $result = binarySearch($arr,FIND_ELEMENT);
    echo $result;
    if($result){
        $counter++;
        $deleteElements[]=$result;
        array_splice($arr,$result,1);
    }
}

print_r($deleteElements);