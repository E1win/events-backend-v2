<?php

use Framework\Routing\Router;

$router = Router::create();

$router->get('/test', function() {
  echo 'hi';
});


return $router;