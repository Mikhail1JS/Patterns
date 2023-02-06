<?php

function combSort($arr)
{
    $gap = count($arr);
    $swap = true;
    while ($gap > 1 || $swap) {
        if ($gap > 1) {
            $gap /= 1.25;
        }
        $swap = false;
        $i = 0;
        while (round($i + $gap) < count($arr)) {
            if ($arr[$i] > $arr[round($i + $gap)]) {
                list($arr[$i], $arr[round($i + $gap)]) = array($arr[round($i + $gap)], $arr[$i]);
                $swap = true;
            }
            ++$i;
        }
    }
    return $arr;
}