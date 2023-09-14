<?php
namespace Framework\Container\Resource;

use Exception;
use Framework\Container\Contract\ContainerResourceInterface;

class ContainerResource implements ContainerResourceInterface
{
  protected string $className;

  protected ?array $parameters = null;

  public static function create(string $className)
  {
    return new ContainerResource($className);
  }

  public function __construct(string $className)
  {
    $this->setClassNameIfExists($className);
  }

  public function setName(string $className): self
  {
    $this->setClassNameIfExists($className);

    return $this;
  }

  public function getName(): string
  {
    return $this->className;
  }
  
  /**
   * Sets parameter, overrides if parameter
   * already exists
   */
  public function setParameter(string $key, mixed $value): self
  {
    $this->parameters[$key] = $value;

    return $this;
  }

  public function getParameters(): array|null
  {
    return $this->parameters;
  }

  public function hasParameters(): bool
  {
    return $this->parameters != null && count($this->parameters) > 0;
  }

  protected function setClassNameIfExists(string $className)
  {
    if (class_exists($className)) {
      $this->className = $className;
    } else {
      throw new Exception("Class {$className} does not exist.");
    }
  }
}

// container resource
// so for example: 
// new ContainerResource(Classname::class)
//    ->parameter(key, value);  