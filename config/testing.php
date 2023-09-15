<?php

use Framework\Container\Resource\ContainerResource;

$dbConfig = require_once __DIR__ . '/database.php';

return [
  App\Test\TestClassOne::class 
    => ContainerResource::create(App\Test\TestClassOne::class)
      ->addParameter(4),
  App\Test\TestClassTwo::class 
    => ContainerResource::create(App\Test\TestClassTwo::class)
      ->addParameter(App\Test\TestClassOne::class)
      ->addParameter(22)
      ->addParameter(null),
  PDO::class
    => ContainerResource::create(PDO::class)
      ->addParameter(sprintf(
        "%s:host=%s;dbname=%s", 
        $dbConfig['driver'], 
        $dbConfig['host'], 
        $dbConfig['name']
        ) 
      )
      ->addParameter($dbConfig['user'])
      ->addParameter($dbConfig['password']),
  Framework\model\Mapper\MapperFactory::class
    => ContainerResource::create(Framework\model\Mapper\MapperFactory::class)
      ->addParameter(PDO::class),
  // App\Test\TestClassThree::class
  //   => ContainerResource::create(App\Test\TestClassThree::class)
  //     ->setParameter('myClass', App\Test\TestClassOne::class),
];