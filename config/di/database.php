<?php

$databaseConfig = require __DIR__ . '/../database.php';

use App\Model\Mapper\Auth\Session;
use App\Model\Mapper\Event;
use App\Model\Mapper\EventCollection;
use App\Model\Mapper\Image;
use App\Model\Mapper\Participant;
use App\Model\Mapper\ParticipantCollection;

use Framework\Auth\Model\Mapper\User;
use Framework\Auth\Model\Mapper\UserCollection;

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
    'registrations'
  ],
  Participant::class => [
    PDO::class,
    'registrations'
  ],
  User::class => [
    PDO::class,
    'users'
  ],
  UserCollection::class => [
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
