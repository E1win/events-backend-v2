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
      $reflectionClass->getConstructor()
    );

    
    $instance = $reflectionClass->newInstanceArgs($args);
    
    echo "<br><br>in resolver: {$className}, instance:";
    echo "<pre>";
    var_dump($instance);
    echo "</pre>";
    echo "<br><br>";

    return $reflectionClass->newInstanceArgs($args);
  }

  private function resolveParameters(
    ContainerResourceInterface $resource,
    ReflectionMethod $reflectionConstructor
  ): array {
    $args = [];

    foreach ($resource->getParameters() as $key => $value) {
      if ($value instanceof ContainerResourceInterface) {
        echo '<br><br>resolving dependency<br><br>';
        $args[] = $this->resolve($value);
      } else {
        $args[] = $value;
      }
    }

    return $args;
  }
}