<?php

use Framework\Routing\Router;

$router = Router::create();

$router->get('/events', [App\Http\Controller\Web\EventController::class, 'index']);
$router->get('/events/{id:number}', [App\Http\Controller\Web\EventController::class, 'show']);

return $router;