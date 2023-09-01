<?php


use App\Controllers\PlanController;
use App\Models\Plan;
use App\Routes\Router;

$router = new Router;

$router->get('/api/plans', function () {
    $controller = new PlanController(new Plan());
    $response = $controller->get();
    echo json_encode($response);
});

$router->run();