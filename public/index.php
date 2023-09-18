<?php

use App\Http\Controller\EventController;
use App\Model\Mapper\Event;
use App\Model\Service\EventService;
use App\Test\TestClassFour;
use App\Test\TestClassOne;
use App\Test\TestClassThree;
use App\Test\TestClassTwo;
use App\Test\TestInterface;
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
use Framework\Model\Mapper\MapperFactory;
use Framework\Routing\Contract\RouterInterface;
use Framework\Routing\Router;

define('ROOT_PATH', __DIR__ . "/../");

/**
 * ADDING COMPOSER AUTOLOADER
 * 
 * So we no longer have to manually load our classes.
 */

require __DIR__ . '/../vendor/autoload.php';

/**
 * GET CONFIGURATION
 */

// $config = require_once __DIR__ . '/../config/di/database.php';
// $aliases = require_once __DIR__ . '/../config/di/alias.php';

// $resourceCollection = new ContainerResourceCollection(
//   $config,
//   new ReflectionAutowiring()
// );

// $resourceCollection->addAliases($aliases);

// $container = new Container(
//   $resourceCollection
// );

/**
 * CREATE APPLICATION
 * 
 * Let application handle incoming request.
 * Then, send appropiate response back to client.
 */

// $app = new App($container);

// var_dump($config);
// echo "<br>";
// echo "<br>";
$config = require __DIR__ . '/../config/di/database.php';

// Maybe still have tables array in Mapper classes
// and then just have a getTable method in the abstract class
// that automatically gets the name using static::class
// which is the key in which they are stored
// for other tables (ex: pivot tables), they can just
// get them manually

$messageFactory = new MessageFactory();

$request = $messageFactory->createServerRequestFromGlobals();

echo '<pre>';
var_dump($request->getRequestTarget());
echo '</pre>';

$router = new Router();

$router->get("/test", function() {
  echo 'In function';
});

$router->get("/test/{id:number}", function() {
  echo 'In function';
});

$router->get("/test/events/{id:number}/{num:number}", function() {
  echo 'In function';
});

$router->group('/api', function(RouterInterface $router) {
  $router->get('/test', function() {
    // . . .
  });
});

$route = $router->match($request);

echo '<br>ROUTE FOUND:<pre>';
var_dump($route);
echo '</pre>';

// $resourceCollection = new ContainerResourceCollection(
//   $config,
//   new ReflectionAutowiring()
// );

// $container = new Container($resourceCollection);

// $eventController = $container->get(EventController::class);

// $event = $eventController->show((new ServerRequest()), 1);

// $eventService = $container->get(EventService::class);

// $event = $eventService->getEventById(1);

// echo "<pre>";
// var_dump($event->toArray());
// echo "</pre>";


// $mapper = $mapperFactory->create(Event::class);

// $service = new EventService($mapper);

// $event = $service->getEventById(1);

// echo '<br><br>EVENT SUCCESFULLY CREATED:<pre>';
// var_dump($event);
// echo "</pre>";

// $myClass->testMethod();
// $resource = $resourceCollection->getResource(TestClassOne::class);

// echo "<pre>";
// var_dump($resource);
// echo "</pre>";

// $resource = $resourceCollection->getResource(TestClassTwo::class);

// echo "<pre>";
// var_dump($resource);
// echo "</pre>";





// $autowiring = new ReflectionAutowiring();

// $resource = $autowiring->autowire(TestClassThree::class);


// var_dump($resource);
// $testing = $resourceCollection->getResource($resource->getParameters()['myClass']);
// var_dump($testing);

// echo '<br/>';
// echo '<br/>';
// echo '<br/>';

// Even duidelijk neerzetten hoe een
// ContainerResource class eruit moet zien.
// Zodat er verder mee gewerkt kan worden

// Moet het gewoon een normaal array zijn met alle parameters?
// voorbeeld voor bijvoorbeeld 
// TestClass(ResponseInterface $response, int $testInt, ?string $optionalString = null);
// $params = [Response::class, 13, null];

// Maak een paar classes waarin we makkelijk dit kunnen proberen

// use Framework\Container\Resource\ContainerResourceCollectionChain;
// use Framework\Container\Resource\ContainerResourceCollection;

// $test1= new ContainerResourceCollection([], null);
// $test2= new ContainerResourceCollection([], null);

// $resourceChain = new ContainerResourceCollectionChain([
//   $resourceCollectionOne,
//   $resourceCollectionTwo
// ]);

// echo '<pre>';
// var_dump($resourceChain);
// echo '</pre>';

// $resourceChain->getResource('t');







// use Framework\Container\Resource\ContainerResource;

// $resource = new ContainerResource(Framework\Message\Response::class);

// $resource
//   ->setParameter('statusCode', 200)
//   ->setParameter('reasonPhrase', "Testing the ContainerResource");

// echo $resource->getName();
// echo '<br/>';
// var_dump($resource->getParameters());
// echo '<br/>';



// commands to setup application here
// set up container
// get data from config / .env to database

// $response = $app->handle(
//  (new MessageFactory)->createServerRequestFromGlobals()
// );

// send response with ResponseSender
