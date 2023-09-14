<?php

namespace Framework\Container;

use Framework\Container\Contract\ContainerResourceInterface;
use Framework\Container\Resource\ContainerResource;

// helper functions to create definitions here.
// if (! function_exists('Framework\Container\create')) {

// }
function create(string $className): ContainerResourceInterface
{
  return new ContainerResource($className);
}