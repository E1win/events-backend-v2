<?php
namespace Framework\Container\Resource;

use Framework\Container\Contract\AutowiringInterface;
use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Framework\Container\Contract\ContainerResourceInterface;

class ContainerResourceCollection implements ContainerResourceCollectionInterface
{
  /**
   * @var ContainerResourceInterface[] $resources
   */
  protected array $resources;

  protected ?AutowiringInterface $autowiring;

  /**
   * @param ContainerResourceInterface[] $resources
   */
  public function __construct(array $resources, ?AutowiringInterface $autowiring = null)
  {
    $this->resources = $resources;
    $this->autowiring = $autowiring;
    $this->autowiring->setParent($this);
  }

  public function getResource(string $name): ?ContainerResourceInterface
  {
    if (array_key_exists($name, $this->resources)) {
      return $this->resources[$name];
    }

    $resource = $this->autowiring->autowire($name);

    $this->resources[$name] = $resource;

    return $resource;

    // Use autowire to get class and parameters

    // call getResource on parameters if it's a dependency
    // if not, throw error

    return null;
  }

  public function getResources(): array
  {
    return $this->resources;
  }

}