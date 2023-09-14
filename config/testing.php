<?php

use Framework\Container\Resource\ContainerResource;

// ContainerResource::create(Framework\Message\Response::class)
//   ->setParameter('statusCode', 201)
//   ->setParameter('reasonPhrase', 'Testing DI'),
return [
  App\Test\TestClassOne::class 
    => ContainerResource::create(App\Test\TestClassOne::class)
      ->setParameter('myNumber', 4),
  App\Test\TestClassThree::class
    => ContainerResource::create(App\Test\TestClassThree::class)
      ->setParameter('myClass', App\Test\TestClassOne::class),
];