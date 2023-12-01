<?php
namespace Framework\Container\Resource;

use Exception;
use Framework\Container\Contract\AutowiringInterface;
use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Framework\Container\Contract\ContainerResourceInterface;
use Framework\Container\Exception\ContainerCantResolveClassParametersException;
use Framework\Container\Exception\ContainerException;
use ReflectionClass;

class ContainerAutowirer implements AutowiringInterface, ContainerResourceCollectionInterface
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

    $parameters = $this->getResourceParameters($constructor, $name);

    // TODO: Fix error when constructer exists
    // but has no parameters

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

  private function getResourceParameters(\ReflectionMethod $constructor, string $className)
  {
    $resourceParameters = [];

    $constructorParameters = $constructor->getParameters();

    if (count($constructorParameters) === 0) {
      return [];
    }

    foreach ($constructorParameters as $index => $parameter) {
      $parameterIsDependency = class_exists($parameter->getType()) || interface_exists($parameter->getType());

      if ($parameterIsDependency) {
        $resourceParameters[$index] = $this->resolveDependencyParameter($parameter);
      } else {
        $resourceParameters[$index] = $this->resolvePrimitiveParameter($parameter, $className);
      }
    }

    return $resourceParameters;
  }

  private function resolveDependencyParameter($parameter)
  {
    $dependency = $parameter->getType();

    if ($this->parent != null) {
      return $this->parent->getResource($dependency->getName());
    }

    return $this->getResource($dependency->getName());
  }

  private function resolvePrimitiveParameter($parameter, $className) {
    if (! $parameter->isDefaultValueAvailable()) {
      throw new ContainerCantResolveClassParametersException($className);
    }
    
    return $parameter->getDefaultValue();
  }

  public function setParent(ContainerResourceCollectionInterface $parent)
  {
    $this->parent = $parent;
  }
}