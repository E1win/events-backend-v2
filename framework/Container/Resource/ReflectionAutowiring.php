<?php
namespace Framework\Container\Resource;

use Exception;
use Framework\Container\Contract\AutowiringInterface;
use Framework\Container\Contract\ContainerResourceCollectionInterface;
use ReflectionClass;

class ReflectionAutowiring implements AutowiringInterface, ContainerResourceCollectionInterface
{
  // . . .

  public function autowire(string $name)
  {
    $reflector = new ReflectionClass($name);

    if (!$reflector->isInstantiable()) {
      throw new Exception("Class {$name} is not instantiable.");
    }

    // get class constructor

    // get constructor params

    // get new instance with dependencies resolved
  }

  public function getDefinition(string $name)
  {
    return $this->autowire($name);
  }

  /**
   * Autowiring cannot guess all definitions
   */
  public function getDefinitions(): array
  {
    return [];
  }
}