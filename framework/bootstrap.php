<?php

define('ROOT_PATH', __DIR__ . "/../");

// Load the autoloader
require __DIR__ . '/../vendor/autoload.php';

// Load environment variables from .env into $_ENV
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
// $dotenv->load();

// APP_DEBUG=true

// DB_HOST=db
// DB_PORT=3306
// DB_NAME=events
// DB_USER=root
// DB_PASS=root

$_ENV['APP_DEBUG'] = true;

$_ENV['DB_HOST'] = 'db';
$_ENV['DB_PORT'] = 3306;
$_ENV['DB_NAME'] = "events";
$_ENV['DB_USER'] = "root";
$_ENV['DB_PASS'] = "root";


date_default_timezone_set('Europe/Amsterdam');

// Load helper functions
require __DIR__ . '/functions.php';