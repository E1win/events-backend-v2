<?php

$databaseConfig = require_once __DIR__ . '/../database.php';

return [
  PDO::class => [
    sprintf(
      "%s:host=%s;dbname=%s", 
      $databaseConfig['driver'], 
      $databaseConfig['host'], 
      $databaseConfig['name']
    ),
    $databaseConfig['user'],
    $databaseConfig['password']
  ],
  App\Model\Mapper\Event::class => [
    PDO::class,
    'events'
  ],
];


// alternative to this:

// App\Model\Mapper\Event::class => [
//    and all parameters here,
// ]
//    probably takes way less time,