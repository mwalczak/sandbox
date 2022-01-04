<?php
$iterations = 10_000_000;

$array1 = [];
$array2 = [];

for($i=0; $i<$iterations; $i++){
    $array1[] = $i;
    $array2[] = $iterations+$i;
}
echo "memory (byte): ". memory_get_peak_usage(true). "\n\n";
$start_time=microtime(true);

$arraySum = array_merge($array1, $array2);

echo "array_merge(array1, array2)\ntime: ". (microtime(true) - $start_time). "\n";
echo "memory (byte): ". memory_get_peak_usage(true). "\n\n";
unset($arraySum);

$start_time=microtime(true);
$arraySum = $array1 + $array2;

echo "array1 + array2\ntime: ". (microtime(true) - $start_time). "\n";
echo "memory (byte): ". memory_get_peak_usage(true). "\n\n";
unset($arraySum);

$start_time=microtime(true);
$arraySum = [...$array1, ...$array2];

echo "[...array1, ...array2]\ntime: ". (microtime(true) - $start_time). "\n";
echo "memory (byte): ". memory_get_peak_usage(true). "\n\n";
