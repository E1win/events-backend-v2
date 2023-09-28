<?php

use Framework\Routing\Router;
use App\Http\Middleware\ExampleMiddleware;

$router = Router::create();
$router->addPrefix('/api');
$router->addMiddleware(ExampleMiddleware::class);

$router->get('/events/{id:number}', [App\Http\Controller\EventController::class, 'show']);
$router->get('/events', [App\Http\Controller\EventController::class, 'index']);

return $router;