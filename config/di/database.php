<?php

$databaseConfig = require __DIR__ . '/../database.php';

use App\Model\Mapper\Event;
use App\Model\Mapper\EventCollection;
use App\Model\Mapper\Image;
use App\Model\Mapper\ParticipantCollection;
use App\Model\Mapper\User;

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
  Event::class => [
    PDO::class,
    'events'
  ],
  EventCollection::class => [
    PDO::class,
    'events'
  ],
  ParticipantCollection::class => [
    PDO::class,
    'participants'
  ],
  User::class => [
    PDO::class,
    'users'
  ],
  Image::class => [
    PDO::class,
    'images'
  ]
];


// alternative to this:

// App\Model\Mapper\Event::class => [
//    and all parameters here,
// ]
//    probably takes way less time,