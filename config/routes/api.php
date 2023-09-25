<?php

use Framework\Routing\Router;
use App\Http\Controller\EventController;
use App\Http\Middleware\ExampleMiddleware;

$router = Router::create();
$router->addPrefix('/api');
$router->addMiddleware(ExampleMiddleware::class);

$router->get('/events/{id:number}', [EventController::class, 'show']);
$router->get('/events', [EventController::class, 'index']);

return $router;