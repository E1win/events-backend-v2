<?php

$databaseConfig = require __DIR__ . '/../database.php';

use App\Model\Mapper\Auth\Session;
use App\Model\Mapper\Event;
use App\Model\Mapper\EventCollection;
use App\Model\Mapper\Image;
use App\Model\Mapper\ParticipantCollection;

use Framework\Auth\Model\Mapper\User;

/**
 * TODO: Some mappers can also just find out their default
 * class by getting their classname tolowercase - s
 * so there's no need to put them in here.
 * 
 * set default value of tableName to null
 * and if no name is set, get name like that
 */

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
  ],
  Session::class => [
    PDO::class,
    'sessions'
  ]
];



// alternative to this:

// App\Model\Mapper\Event::class => [
//    and all parameters here,
// ]
//    probably takes way less time,