<?php

use Framework\Routing\Router;
use App\Http\Controller\EventController;

$router = Router::create();
$router->addPrefix('/api');

$router->get('/event/{id:number}', [EventController::class, 'show']);

return $router;