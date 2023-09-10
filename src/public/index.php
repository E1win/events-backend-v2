<?php

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

// $app = require_once __DIR__ . '/../bootstrap/app.php';
// Add application here

// send response

echo 'Hello World!';