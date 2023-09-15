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

  public function __construct(string $className, ?array $parameters = null)
  {
    $this->setClassNameIfExists($className);
    $this->parameters = $parameters;
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

  public function addParameter(mixed $value): self
  {
    $this->parameters[] = $value;

    return $this;
  }
  
  /**
   * Sets parameter, overrides if parameter
   * already exists
   */
  public function setParameter(string $index, mixed $value): self
  {
    $this->parameters[$index] = $value;

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