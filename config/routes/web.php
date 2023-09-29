<?php

use Framework\Routing\Router;
use App\Http\Controller\Web\EventController;


$router = Router::create();

$router->get('/events', [EventController::class, 'index']);
$router->post('/events', [EventController::class, 'store']);
$router->get('/events/{id:number}', [EventController::class, 'show']);

return $router;