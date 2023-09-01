<?php

use App\Controllers\PlanController;
use App\Models\Plan;
use App\Router;

require_once '../vendor/autoload.php';

$router = new Router;

$router->get('/api/plans', function () {
    $controller = new PlanController(new Plan());
    $response = $controller->get();
    echo json_encode($response);
});

$router->run();