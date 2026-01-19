<?php

$numbers = [1, 2, 3];
$items = ['a', 'b', 'c'];
$strings = ['foo', 'bar', null];
$listA = [1, 2];
$listB = [3, 4];

$doubled = array_map(fn($x) => $x * 2, $numbers);

$doubled = array_map(fn(int $x) => $x * 2, $numbers);

$sums = array_map(fn($x, $y) => $x + $y, $listA, $listB);

$doubled = array_map(fn(int $x): int => $x * 2, $numbers);

$ids = array_map(fn() => 42, $items);

$lengths = array_map(fn(?string $x): ?int => $x === null ? null : strlen($x), $strings);

$values = array_filter($items, fn(int|string|null $x): bool => $x !== null);

array_walk($items, fn(string $msg): null => print($msg));

$total = array_reduce($numbers, fn(int $carry, int $num): int => $carry + $num, 0);

$sum = array_reduce($numbers, fn(...$nums) => array_sum($nums), 0);