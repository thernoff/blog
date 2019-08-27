<?php

spl_autoload_register(function ($class) {
    if (file_exists(__DIR__ . '/' . str_replace('\\', '/', $class) . '.php')) {
        require __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    }
});
