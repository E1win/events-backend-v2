<?php

use App\Test\TestClassFour;
use App\Test\TestClassOne;
use App\Test\TestClassThree;
use App\Test\TestClassTwo;
use Framework\Message\Factory as MessageFactory;
use Framework\Application\App;
use Framework\Container\Container;
use Framework\Container\Resource\ContainerResource;
use Framework\Container\Resource\ContainerResourceCollection;
use Framework\Container\Resource\ContainerResourceCollectionChain;
use Framework\Message\Request;
use Framework\Message\Response;
use Framework\Container\Resource\ReflectionAutowiring;


/**
 * ADDING COMPOSER AUTOLOADER
 * 
 * So we no longer have to manually load our classes.
 */

require __DIR__ . '/../vendor/autoload.php';

$config = require __DIR__ . '/../config/testing.php';

var_dump($config);
echo '<br/>';
echo '<br/>';
echo '<br/>';

$resourceCollection = new ContainerResourceCollection(
  $config,
  new ReflectionAutowiring()
);


echo '<br/>';
echo '<br/>';
echo '<br/>';

$container = new Container($resourceCollection);

$myClass = $container->get(TestClassFour::class);


echo '<br><br>THE GOTTEN CLASS<br>';
echo "<pre>";
var_dump($myClass);
echo "</pre>";

$myClass = $container->get(TestClassThree::class);

// $myClass->testMethod();
// $resource = $resourceCollection->getResource(TestClassOne::class);

// echo "<pre>";
// var_dump($resource);
// echo "</pre>";

// $resource = $resourceCollection->getResource(TestClassTwo::class);

// echo "<pre>";
// var_dump($resource);
// echo "</pre>";


echo '<br/>';
echo '<br/>';
echo '<br/>';



// $autowiring = new ReflectionAutowiring();

// $resource = $autowiring->autowire(TestClassThree::class);


// var_dump($resource);
// $testing = $resourceCollection->getResource($resource->getParameters()['myClass']);
// var_dump($testing);

// require __DIR__ . '/../testing/testing.php';
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



// $resourceCollectionOne = new ContainerResourceCollection(
//   [
//     ContainerResource::create(Response::class),
//     ContainerResource::create(Request::class),
//   ]
// );

// $resourceCollectionTwo = new ContainerResourceCollection(
//   [
//     ContainerResource::create(Response::class),
//     ContainerResource::create(Request::class),
//   ]
// );

// echo '<pre>';
// var_dump($resourceCollectionOne);
// echo '</pre>';

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

/**
 * RUN APPLICATION
 * 
 * Let application handle incoming request.
 * Then, send appropiate response back to client.
 */
// $app = new App();

// commands to setup application here
// set up container
// get data from config / .env to database

// $response = $app->handle(
//  (new MessageFactory)->createServerRequestFromGlobals()
// );

// send response with ResponseSender
