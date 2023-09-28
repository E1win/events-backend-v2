<?php

/**
 * TODO: probably don't need prefix here
 * since it's also set in the routes config itself.
 */

// "file" => "prefix"
return [
  'directory' => __DIR__ . '/routes/',
  'routes' => [
    'api.php',
    'web.php'
  ]
  // "api.php" => '/api',
  // "web.php" => '',
];