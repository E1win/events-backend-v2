<?php

$dbConfig = require_once __DIR__ . '/../database.php';

return [
  PDO::class => [
    sprintf(
      "%s:host=%s;dbname=%s", 
      $dbConfig['driver'], 
      $dbConfig['host'], 
      $dbConfig['name']
    ),
    $dbConfig['user'],
    $dbConfig['password']
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