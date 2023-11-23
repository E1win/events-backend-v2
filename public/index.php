<?php

use Framework\Message\Factory as MessageFactory;
use Framework\Application\App;
use Framework\Container\Container;
use Framework\Routing\RouteGatherer;

/**
 * BOOTSTRAP APPLICATION
 * 
 * Loads autoloader, environment variables
 * and helper functions
 */

echo 'Testing this shittt';
exit;

// require_once __DIR__ . '/../framework/bootstrap.php';

/**
 * CREATE CONTAINER
 */

$container = Container::createWithDefaultConfiguration();

/**
 * CREATE APPLICATION
 * 
 * Let application handle incoming request.
 * Then, send appropiate response back to client.
 */

$app = new App($container, new RouteGatherer());

$app->run(
  (new MessageFactory())->createServerRequestFromGlobals()
);