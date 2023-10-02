<?php

use App\Http\Controller\EventController;
use App\Http\Middleware\ExampleMiddleware;
use App\Http\Middleware\ExampleMiddlewareTwo;
use App\Model\Mapper\Event;
use App\Model\Service\EventService;
use Framework\Message\Factory as MessageFactory;
use Framework\Application\App;
use Framework\Container\Container;
use Framework\Container\Resource\ContainerResource;
use Framework\Container\Resource\ContainerResourceCollection;
use Framework\Container\Resource\ContainerResourceCollectionChain;
use Framework\Message\Request;
use Framework\Message\Response;
use Framework\Container\Resource\ReflectionAutowiring;
use Framework\Message\ServerRequest;
use Framework\Routing\Contract\RouterInterface;
use Framework\Routing\Router;
use Framework\Middleware\MiddlewareStack;
use Framework\Routing\RouteGatherer;
use Framework\View\TemplateLoader;

/**
 * BOOTSTRAP APPLICATION
 * 
 * Loads autoloader, environment variables
 * and helper functions
 */

require_once __DIR__ . '/../framework/bootstrap.php';

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