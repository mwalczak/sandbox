<?php
spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$iterations = 1_000_000;

//$time = new Time();
//$time = Time::createMonth(2020, 12);
$time = Time::now()->getModified('+1 month');
echo "memory (byte): ". memory_get_peak_usage(true). "\n";

$start_time=microtime(true);
echo "\ntesting isFutureMonth with $iterations iterations:\n";

for($i=0; $i<$iterations; $i++){
    $isFuture = $time->isFutureMonth();
}

echo "time: ". (microtime(true) - $start_time). "\n";
echo "memory (byte): ". memory_get_peak_usage(true). "\n\n";

$start_time=microtime(true);
echo "\ntesting isFutureMonthAlt with $iterations iterations:\n";

for($i=0; $i<$iterations; $i++){
    $isFuture = $time->isFutureMonthAlt();
}

echo "time: ". (microtime(true) - $start_time). "\n";
echo "memory (byte): ". memory_get_peak_usage(true). "\n";

$start_time=microtime(true);
echo "\ntesting isFutureMonthAlt2 with $iterations iterations:\n";
$date = date('Ym');
for($i=0; $i<$iterations; $i++){
    $isFuture = $time->isFutureMonthAlt2($date);
}

echo "time: ". (microtime(true) - $start_time). "\n";
echo "memory (byte): ". memory_get_peak_usage(true). "\n";

