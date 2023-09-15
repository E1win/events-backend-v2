<?php

use Framework\Container\Resource\ContainerResource;

// ContainerResource::create(Framework\Message\Response::class)
//   ->setParameter('statusCode', 201)
//   ->setParameter('reasonPhrase', 'Testing DI'),
return [
  App\Test\TestClassOne::class 
    => ContainerResource::create(App\Test\TestClassOne::class)
      ->addParameter(4),
  App\Test\TestClassTwo::class 
    => ContainerResource::create(App\Test\TestClassTwo::class)
      ->addParameter(App\Test\TestClassOne::class)
      ->addParameter(22)
      ->addParameter(null),
  // App\Test\TestClassThree::class
  //   => ContainerResource::create(App\Test\TestClassThree::class)
  //     ->setParameter('myClass', App\Test\TestClassOne::class),
];