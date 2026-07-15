<?php
require_once __DIR__ . '/../config/config.php';
$keys = array_keys($_ENV);
$serverKeys = array_keys($_SERVER);
$allKeys = array_unique(array_merge($keys, $serverKeys));
sort($allKeys);
foreach ($allKeys as $k) {
    $v = env($k);
    if ($v !== null) {
        $masked = (str_contains(strtolower($k), 'pass') || str_contains(strtolower($k), 'key') || str_contains(strtolower($k), 'token')) 
            ? '[MASKED]' 
            : $v;
        echo "$k = $masked\n";
    }
}
?>
