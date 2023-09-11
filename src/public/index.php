<?php

use Framework\Message\Factory as MessageFactory;

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

$app = require_once __DIR__ . '/../bootstrap/app.php';

$response = $app->handle(
 (new MessageFactory)->createServerRequestFromGlobals()
);

// send response with ResponseSender

echo 'Hello World!';