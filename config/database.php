<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");

$dotenv->load();

return [
  'driver' => 'mysql',
  'url' => $_ENV['DB_URL'],
  'port' => $_ENV['DB_PORT'],
  'database_name' => $_ENV['DB_NAME'],
  'user' => $_ENV['DB_USER'],
  'password' => $_ENV['DB_PASS'],
  'options' => '',
];