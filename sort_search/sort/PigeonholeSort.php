<?php

function __addDictionary(int $n, array &$dictionary): void
{
    if (isset($dictionary[$n])) {
        $dictionary[$n]++;
        return;
    }
    $dictionary[$n] = 1;
}


function pigeonholeSort(array $list): array
{
    if (empty($list)) {
        return [];
    }
    $min = $list[0];
    $max = $list[0];
    $dictionary = [];
    foreach ($list as $n) {
        if ($min > $n) {
            $min = $n;
        } elseif ($max < $n) {
            $max = $n;
        }
        __addDictionary($n, $dictionary);
    }
    $list = [];
    for ($i = $min; $i <= $max; $i++) {
        if (!isset($dictionary[$i])) {
            continue;
        }
        for ($j = 0; $j < $dictionary[$i]; $j++) {
            $list[] = $i;
        }
    }
    return $list;
}
