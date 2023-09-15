<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");

$dotenv->load();

return [
  'driver' => 'mysql',
  'host' => $_ENV['DB_HOST'],
  'port' => $_ENV['DB_PORT'],
  'name' => $_ENV['DB_NAME'],
  'user' => $_ENV['DB_USER'],
  'password' => $_ENV['DB_PASS'],
  'options' => '',
];