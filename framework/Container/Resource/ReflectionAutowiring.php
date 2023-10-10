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

  public function __construct(
    private ?ContainerResourceCollectionInterface $parent = null
  )
  {
  }

  public function autowire(string $name): ContainerResourceInterface|null
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

    // TODO: Fix error when constructer exists
    // but has no parameters
    if ($parameters == null) {
      throw new ContainerException("Can't resolve parameters of class '{$name}' in Container");
    }

    return new ContainerResource($name, $parameters);
  }

  public function getResource(string $name): ContainerResourceInterface|null
  {
    return $this->autowire($name);
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
    $resourceParameters = [];

    $constructorParameters = $constructor->getParameters();

    if (count($constructorParameters) === 0) {
      return [];
    }

    foreach ($constructorParameters as $index => $parameter) {
      $dependency = class_exists($parameter->getType()) || interface_exists($parameter->getType()) ? $parameter->getType() : null;

      if ($dependency === null) {
        // Check if default value for a parameter is available
        if ($parameter->isDefaultValueAvailable()) {
          $resourceParameters[$index] = $parameter->getDefaultValue();
        } else {
          return null;
        }
      } else {
        if ($this->parent != null) {
          // TODO: First check here if dependency has primitive values.
          // To avoid unnecessarily going back up the chain.
          $resourceParameters[$index] = $this->parent->getResource($dependency->getName());
        } else {
          $resourceParameters[$index] = $this->getResource($dependency->getName());
        }
      }
    }

    return $resourceParameters;
  }

  public function setParent(ContainerResourceCollectionInterface $parent)
  {
    $this->parent = $parent;
  }
}