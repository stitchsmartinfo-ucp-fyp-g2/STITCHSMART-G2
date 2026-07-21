<?php
header('Content-Type: text/plain');

$dir = __DIR__ . '/public/uploads/products/';
echo "Target Directory: $dir\n";

if (!is_dir(__DIR__ . '/public')) {
    echo "/public does not exist!\n";
}
if (!is_dir(__DIR__ . '/public/uploads')) {
    echo "/public/uploads does not exist!\n";
} else {
    echo "/public/uploads exists.\n";
    echo "Is writable? " . (is_writable(__DIR__ . '/public/uploads') ? 'Yes' : 'No') . "\n";
    echo "Owner ID: " . fileowner(__DIR__ . '/public/uploads') . "\n";
    echo "Permissions: " . substr(sprintf('%o', fileperms(__DIR__ . '/public/uploads')), -4) . "\n";
}

if (!is_dir($dir)) {
    echo "/products does not exist, trying to create...\n";
    $success = @mkdir($dir, 0777, true);
    if (!$success) {
        $error = error_get_last();
        echo "mkdir failed! Error: " . ($error['message'] ?? 'Unknown error') . "\n";
    } else {
        echo "mkdir succeeded!\n";
    }
} else {
    echo "/products already exists.\n";
    echo "Is writable? " . (is_writable($dir) ? 'Yes' : 'No') . "\n";
    echo "Owner ID: " . fileowner($dir) . "\n";
    echo "Permissions: " . substr(sprintf('%o', fileperms($dir)), -4) . "\n";
}

$testFile = $dir . 'test.txt';
$bytes = @file_put_contents($testFile, 'test');
if ($bytes !== false) {
    echo "Successfully wrote to directory!\n";
    unlink($testFile);
} else {
    $error = error_get_last();
    echo "Failed to write to directory! Error: " . ($error['message'] ?? 'Unknown error') . "\n";
}
