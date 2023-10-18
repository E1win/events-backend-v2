<?php

use App\Http\Controller\Web\AuthController;
use Framework\Routing\Router;
use App\Http\Controller\Web\EventController;
use App\Http\Controller\Web\ViewController;
use Framework\Auth\Middleware\AuthMiddleware;
use Framework\Auth\Middleware\LoginRedirectMiddleware;

$router = Router::create();

$router->addMiddlewares([
  LoginRedirectMiddleware::class
]);


$router->get('/events', [EventController::class, 'index']);
$router->post('/events', [EventController::class, 'store']);
$router->get('/events/{id:number}', [EventController::class, 'show']);

$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

$router->group('', function(Router $router) {
  $router->get('/', [ViewController::class, 'home']);
  $router->get('/auth', [AuthController::class, 'authRoute']);
  $router->post('/logout', [AuthController::class, 'logout']);
})->addMiddlewares([
  UserInRequestMiddleware::class,
  AuthMiddleware::class
]);

return $router;