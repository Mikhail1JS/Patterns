<?php

function quickSortLesson(array $mas): array
{
    $arrCount = count($mas);

    if ($arrCount <= 1) {
        return $mas;
    }

    $base = $mas[0];
    $left = [];
    $right = [];

    for ($i = 1; $i < $arrCount; $i++) {

        if ($base >= $mas[$i]) {
            $left[] = $mas[$i];
        } else {
            $right[] = $mas[$i];
        }
    }

    $left = quickSortLesson($left);
    $right = quickSortLesson($right);

    return array_merge($left, [$base], $right);
}