<?php
namespace Framework\Container\Resource;

use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Framework\Container\Contract\ContainerResourceInterface;

class ContainerResourceCollection implements ContainerResourceCollectionInterface
{
  /**
   * @var ContainerResourceInterface[] $resources
   */
  protected array $resources;

  /**
   * @param ContainerResourceInterface[] $resources
   */
  public function __construct(array $resources)
  {
    $this->resources = $resources;
  }

  public function getResource(string $name): ?ContainerResourceInterface
  {
    if (array_key_exists($name, $this->resources)) {
      return $this->resources[$name];
    }

    return null;
  }

  public function getResources(): array
  {
    return $this->resources;
  }
}