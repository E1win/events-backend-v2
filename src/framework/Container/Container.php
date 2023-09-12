<?php
namespace Framework\Container;

use Exception;
use Psr\Container\ContainerInterface;
use ReflectionClass;

// https://medium.com/tech-tajawal/dependency-injection-di-container-in-php-a7e5d309ccc6
// https://github.com/PHP-DI/PHP-DI/tree/master

class Container implements ContainerInterface
{
  protected array $instances = [];

  public function get(string $id)
  {
    
  }

  public function has(string $id): bool
  {
    
    return false;
  }

  protected function resolve(string $id)
  {
    // USE AUTOWIRING CLASS FOR THIS INSTEAD

    $reflector = new ReflectionClass($id);

    if (!$reflector->isInstantiable()) {
      throw new Exception("Class {$id} is not instantiable.");
    }

    // get class constructor

    // get constructor params

    // get new instance with dependencies resolved
  }

  protected function getDependencies($parameters)
  {

  }
}