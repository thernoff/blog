<?php

function dd($value) {
    if (is_array($value) || is_object($value)) {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    } else {
        echo "<pre>";
        echo $value;
        echo "</pre>";
    }
    die;
}

use Application\Controllers\Main;
use Application\Core\Router;

require __DIR__ . '/autoload.php';

$router = new Router();
$router->run();
