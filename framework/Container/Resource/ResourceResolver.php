<?php
namespace Framework\Container\Resource;

use Exception;
use Framework\Container\Contract\ContainerResourceInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionClass;
use ReflectionMethod;

class ResourceResolver
{
  public function resolve(ContainerResourceInterface $resource)
  {
    $className = $resource->getName();

    $reflectionClass = new ReflectionClass($className);

    try {
      $args = $this->resolveParameters(
        $resource,
        $reflectionClass->getConstructor()
      );

      return $reflectionClass->newInstanceArgs($args);
    } catch (Exception $e) {
      // . . .
    }

    return $resource;
  }

  private function resolveParameters(
    ContainerResourceInterface $resource,
    ReflectionMethod $reflectionConstructor
  ): array {
    $args = [];

    foreach ($resource->getParameters() as $key => $value) {
      if ($value instanceof ContainerResourceInterface) {
        $args[] = $this->resolve($value);
      } else {
        $args[] = $value;
      }
      echo "key: <br>";
      var_dump($key);
      echo "<br>value: <br>";
      var_dump($value);
    }

    return $args;
  }
}