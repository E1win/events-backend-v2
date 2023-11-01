<?php

use Framework\Routing\Router;
use App\Http\Controller\Api\EventController;
use Framework\Auth\Middleware\AuthMiddleware;
use App\Http\Controller\Api\AuthController;
use Framework\Auth\Middleware\UserInRequestMiddleware;

$router = Router::create();
$router->addPrefix('/api');


$router->post('/login', [AuthController::class, 'login']);
$router->group('', function(Router $router) {
  $router->post('/logout', [AuthController::class, 'logout']);
  
  $router->get('/events', [EventController::class, 'index']);
  $router->post('/events', [EventController::class, 'store']);
  $router->get('/events/{id:number}', [EventController::class, 'show']);
  $router->get('/events/{id:number}/participants', [EventController::class, 'participants']);

})->addMiddlewares([
  UserInRequestMiddleware::class,
  AuthMiddleware::class
]);

return $router;