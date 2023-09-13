<?php

use Framework\Message\Factory as MessageFactory;
use Framework\Application\App;

/**
 * ADDING COMPOSER AUTOLOADER
 * 
 * So we no longer have to manually load our classes.
 */

require __DIR__ . '/../vendor/autoload.php';

/**
 * RUN APPLICATION
 * 
 * Let application handle incoming request.
 * Then, send appropiate response back to client.
 */
$app = new App();

$response = $app->handle(
 (new MessageFactory)->createServerRequestFromGlobals()
);

// send response with ResponseSender

echo 'Hello World!';