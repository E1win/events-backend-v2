<?php
namespace Framework\Container\Resource;

use Exception;
use Framework\Container\Contract\AutowiringInterface;
use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Framework\Container\Contract\ContainerResourceInterface;
use Framework\Container\Exception\ContainerException;
use ReflectionClass;

class ReflectionAutowiring implements AutowiringInterface, ContainerResourceCollectionInterface
{
  // . . .

  public function autowire(string $name)
  {
    $reflector = new ReflectionClass($name);

    if (!$reflector->isInstantiable()) {
      throw new ContainerException("Class {$name} is not instantiable.");
    }

    $constructor = $reflector->getConstructor();

    if ($constructor == null) {
      return new ContainerResource($name);
    }

    $parameters = $this->getResourceParameters($constructor);

    return $parameters;

    // get class constructor

    // get constructor params

    // get new instance with dependencies resolved
  }

  public function getResource(string $name): ContainerResourceInterface|null
  {
    // return $this->autowire($name);
    return null;
  }

  /**
   * Autowiring cannot guess all definitions
   */
  public function getResources(): array
  {
    return [];
  }

  private function getResourceParameters(\ReflectionMethod $constructor)
  {
    $parameters = [];

    foreach ($constructor->getParameters() as $index => $parameter) {
      echo $parameter;
      echo '<br/>';
      
      echo '<pre>';

      $dependency = class_exists($parameter->getType()) ? $parameter->getType() : null;

      echo class_exists($parameter->getType());
      // echo is_object($parameter->getType());
      echo '</pre>';

      if ($dependency === null) {
        // Check if default value for a parameter is available
        if ($parameter->isDefaultValueAvailable()) {
          $parameters[$parameter->getName()] = $parameter->getDefaultValue();
        } else {
          throw new Exception("Can't resolvesfeasfldkjaflka");
        }
      } else {
        // resolve dependencies maybe?
        $parameters[$parameter->getName()] = $dependency->getName();
      }
    }

    return $parameters;
  }
}