<?php

use Framework\Message\Factory as MessageFactory;
use Framework\Application\App;

/**
 * ADDING COMPOSER AUTOLOADER
 * 
 * So we no longer have to manually load our classes.
 */

require __DIR__ . '/../vendor/autoload.php';

use Framework\Container\Resource\ContainerResource;

$resource = new ContainerResource(Framework\Message\Response::class);

$resource
  ->setParameter('statusCode', 200)
  ->setParameter('reasonPhrase', "Testing the ContainerResource");

echo $resource->getName();
echo '<br/>';
var_dump($resource->getParameters());
echo '<br/>';

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
