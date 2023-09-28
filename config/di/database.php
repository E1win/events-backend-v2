<?php

$databaseConfig = require __DIR__ . '/../database.php';

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
  App\Model\Mapper\EventCollection::class => [
    PDO::class,
    'events'
  ],
  App\Model\Mapper\ParticipantCollection::class => [
    PDO::class,
    'participants'
  ],
];


// alternative to this:

// App\Model\Mapper\Event::class => [
//    and all parameters here,
// ]
//    probably takes way less time,