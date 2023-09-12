<?php
namespace Framework\Container;

use Framework\Container\Contract\AutowiringInterface;
use Framework\Container\Contract\DefinitionSourceInterface;

class ReflectionAutowiring implements AutowiringInterface, DefinitionSourceInterface
{
  // . . .

  public function autowire(string $name)
  {
    $reflector = new ReflectionClass($id);

    if (!$reflector->isInstantiable()) {
      throw new Exception("Class {$id} is not instantiable.");
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