<?php
$log = '/tmp/log';
$cmd = sprintf('php %s >> %s', __DIR__.'/proc.php', $log);
for ($i = 0; $i < 5; $i++) {
    echo date('Y-m-d H:i:s') . PHP_EOL;
    echo $cmd . PHP_EOL;
    exec($cmd);
}
$logs = file_get_contents($log);
echo 'Log:' . PHP_EOL;
echo $logs . PHP_EOL;
