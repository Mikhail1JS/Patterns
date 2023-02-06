<?php


function __merge(array &$list, int $start, int $end, int $separator): void
{
    $rightIndex = $separator;
    $rightEnd = $end;
    $left = array_slice($list, $start, $separator - $start);
    $leftIndex = 0;
    $leftEnd = count($left) - 1;
    for ($i = $start; $i <= $end; $i++) {
        if ($leftIndex <= $leftEnd and $rightIndex <= $rightEnd) {
            if ($left[$leftIndex] <= $list[$rightIndex]) {
                $list[$i] = $left[$leftIndex];
                $leftIndex++;
            } else {
                $list[$i] = $list[$rightIndex];
                $rightIndex++;
            }
        } elseif ($rightIndex > $rightEnd) {
            $list[$i] = $left[$leftIndex];
            $leftIndex++;
        }
    }
}


function __mergeSort(array &$list, int $start, int $end): void
{
    $count = $end - $start + 1;
    if ($count < 3) {
        if ($count == 2 and $list[$start] > $list[$end]) {
            list($list[$start], $list[$end]) = array($list[$end], $list[$start]);
        }
        return;
    }
    $middle = (int)($start + $count / 2);
    __mergeSort($list, $start, $middle - 1);
    __mergeSort($list, $middle, $end);
    __merge($list, $start, $end, $middle);
}

function mergeSort(array &$list): void
{
    __mergeSort($list, 0, count($list) - 1);
}


