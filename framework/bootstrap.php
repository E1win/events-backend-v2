<?php

define('ROOT_PATH', __DIR__ . "/../");

// Load the autoloader
require __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env into $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

date_default_timezone_set('Europe/Amsterdam');

// Load helper functions
require __DIR__ . '/functions.php';