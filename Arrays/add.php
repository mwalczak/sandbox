<?php
global $array1, $array2;
require_once __DIR__ . '/pre.php';

$start_time=microtime(true);

$arraySum = $array1 + $array2;

echo "array1 + array2\ntime: ". (microtime(true) - $start_time). "\n";
echo "memory (byte): ". memory_get_peak_usage(true). "\n\n";

