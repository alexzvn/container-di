<?php

spl_autoload_register(function (string $class) {

    $file = explode('\\', $class);

    $vendor = array_shift($file);

    $filePath = __DIR__ . '/' . implode('/', $file) . '.php';

    if ($vendor === 'IquxByte' && file_exists($filePath)) {
        require_once $filePath;
    }
});