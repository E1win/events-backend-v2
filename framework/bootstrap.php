<?php

define('ROOT_PATH', __DIR__ . "/../");

// Load the autoloader
require __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env into $_ENV
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

// Load helper functions
require __DIR__ . '/functions.php';