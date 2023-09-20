<?php

use Framework\Middleware\MiddlewareStack;
use Framework\Routing\Router;

$router = new Router((new MiddlewareStack));

$router->addPrefix('/api');

$router->get("/test", function() {
  echo 'In function';
});

// Then maybe in app:
// $routerGroup->config('routes-web');

// $router->group('/api', $routerGroup);

return $router;