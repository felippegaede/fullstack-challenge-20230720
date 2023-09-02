<?php

use App\Controllers\PlanController;
use App\Models\Plan;
use App\Routes\Router;

$router = new Router;

$router->get('/api/plans', function ($query) {
    $controller = new PlanController(new Plan());
    $response = $controller->get($query);

    echo json_encode($response);
});

$router->run();