<?php

use Application\Controllers\Main;
use Application\Core\Router;

require __DIR__ . '/autoload.php';
//require __DIR__ . '/Application/Router.php';

$router = new Router();
$router->run();
//session_start();