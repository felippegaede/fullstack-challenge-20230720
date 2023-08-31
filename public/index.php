<?php

use App\Router;

require_once '../vendor/autoload.php';

$router = new Router;

$router->get('/api/plans', function () {

    echo 'Hello, world!!';
});

$router->run();