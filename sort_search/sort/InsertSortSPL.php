<?php


function insertSort(array &$list): void
{
    $count = count($list);
    for ($i = 1; $i < $count; $i++) {
        $insertItem = $list[$i];
        $j = $i - 1;
        while (isset($list[$j]) and $list[$j] > $insertItem) {
            $list[$j + 1] = $list[$j];
            $j--;
        }
        $list[$j + 1] = $insertItem;
    }
}


function __splBinarySearch(int $item, SplDoublyLinkedList $sortedlist): int
{
    $low = 0;
    $high = $sortedlist->count() - 1;
    while ($low <= $high) {
        $middle = floor(($high + $low) / 2);
        if ($sortedlist->offsetGet($middle) == $item) {
            return $middle;
        }
        if ($sortedlist->offsetGet($middle) > $item) {
            $high = $middle - 1;
        } else {
            $low = $middle + 1;
        }
    }
    if ($sortedlist->offsetGet($high) > $item) {
        return $high;
    }
    return $low;
}


function splInsertSort(array $list): SplDoublyLinkedList
{
    $count = count($list);
    $sortedList = new SplDoublyLinkedList();
    if ($count < 2) {
        if (empty($list)) {
            return $sortedList;
        }
        $sortedList->push($list[0]);
        return $sortedList;
    }
    $sortedList->push($list[0]);
    for ($i = 1; $i < $count; $i++) {
        if ($sortedList->top() <= $list[$i]) {
            $sortedList->push($list[$i]);
            continue;
        }
        if ($sortedList->bottom() >= $list[$i]) {
            $sortedList->unshift($list[$i]);
            continue;
        }
        $key = __splBinarySearch($list[$i], $sortedList);
        $sortedList->add($key, $list[$i]);
    }
    return $sortedList;
}

