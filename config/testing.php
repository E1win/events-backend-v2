<?php

use Framework\Container\Resource\ContainerResource;

return [
  ContainerResource::create(Framework\Message\Response::class)
    ->setParameter('statusCode', 201)
    ->setParameter('reasonPhrase', 'Testing DI'),
  
];