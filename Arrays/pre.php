<?php
$iterations = $argv[1] ?? 1_000_000;

$array1 = [];
$array2 = [];

for($i=0; $i<$iterations; $i++){
    $array1[] = $i;
    $array2[] = $iterations+$i;
}
echo "memory (byte): ". memory_get_peak_usage(true). "\n\n";