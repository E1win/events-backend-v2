<?php

use Framework\Routing\Router;
use App\Http\Controller\EventController;
use App\Http\Middleware\ExampleMiddleware;

$router = Router::create();
$router->addPrefix('/api');
$router->addMiddleware(ExampleMiddleware::class);

$router->get('/event/{id:number}', [EventController::class, 'show']);

return $router;