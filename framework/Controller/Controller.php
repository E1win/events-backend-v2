<?php
namespace Framework\Controller;

use BadMethodCallException;

abstract class Controller
{
  public function callAction($method, $parameters)
  {
    return $this->{$method}(...array_values($parameters));
  }

  // magic __call function for bad method calls
  public function __call(string $name, array $arguments)
  {
    throw new BadMethodCallException(sprintf(
      "Method %s::%s does not exist.", static::class, $name
    ));
  }
}