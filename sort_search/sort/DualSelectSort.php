<?php


function dualSelectSort(array &$list): void
{
    if (count($list) == 0) {
        return;
    }
    $left = 0;
    $right = count($list) - 1;
    while ($left < $right) {
        list($min, $max) = array($left, $right);
        if ($list[$min] > $list[$max]) {
            list($list[$max], $list[$min]) = array($list[$min], $list[$max]);
        }
        for ($i = $left + 1; $i < $right; $i++) {
            if ($list[$min] > $list[$i]) {
                $min = $i;
            } elseif ($list[$max] < $list[$i]) {
                $max = $i;
            }
        }
        if ($list[$min] < $list[$left]) {
            list($list[$min], $list[$left]) = array($list[$left], $list[$min]);
        }
        if ($list[$max] > $list[$right]) {
            list($list[$max], $list[$right]) = array($list[$right], $list[$max]);
        }
        $left++;
        $right--;
    }
}
