<?php

use Framework\Routing\Router;
use App\Http\Controller\Api\EventController;
use Framework\Auth\Middleware\AuthMiddleware;
use App\Http\Controller\Api\AuthController;

$router = Router::create();
$router->addPrefix('/api');

$router->get('/events/{id:number}', [EventController::class, 'show']);
$router->get('/events/{id:number}/participants', [EventController::class, 'participants']);
$router->get('/events', [EventController::class, 'index']);

$router->group('', function(Router $router) {
  $router->post('/logout', [AuthController::class, 'logout']);
  $router->post('/login', [AuthController::class, 'login']);
})->addMiddleware(AuthMiddleware::class);

return $router;