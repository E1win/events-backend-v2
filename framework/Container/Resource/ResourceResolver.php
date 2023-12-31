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

    $args = $this->resolveParameters(
      $resource,
    );

    return $reflectionClass->newInstanceArgs($args);
  }

  private function resolveParameters(
    ContainerResourceInterface $resource,
  ): array {
    $args = [];

    foreach ($resource->getParameters() as $key => $value) {
      if ($value instanceof ContainerResourceInterface) {
        $args[] = $this->resolve($value);
      } else {
        $args[] = $value;
      }
    }

    return $args;
  }
}