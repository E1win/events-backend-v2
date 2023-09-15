<?php
namespace Framework\Container\Resource;

use Framework\Container\Contract\AutowiringInterface;
use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Framework\Container\Contract\ContainerResourceInterface;
use Framework\Container\Exception\NotFoundException;

class ContainerResourceCollection implements ContainerResourceCollectionInterface
{
  private array $resources;

  private array $cachedResources = [];

  private ?AutowiringInterface $autowiring;

  private array $resourceAliases = [];

  /**
   * @param ContainerResourceInterface[] $resources
   */
  public function __construct(
    array $resources = [], 
    ?AutowiringInterface $autowiring = null
  ) {
    $this->resources = $resources;
    $this->autowiring = $autowiring;
    $this->autowiring->setParent($this);
  }

  public function getResource(string $name): ?ContainerResourceInterface
  {
    if (array_key_exists($name, $this->cachedResources)) {
      return $this->cachedResources[$name];
    }

    if (interface_exists($name)) {
      return $this->getResourceWithAlias($name);
    }

    if (array_key_exists($name, $this->resources)) {
      $resource = $this->resources[$name];

      $this->resolveUncachedDependencies($resource);
      $this->cachedResources[$name] = $resource;

      return $this->cachedResources[$name];
    }

    $resource = $this->autowiring->autowire($name);

    if ($resource != null) {
      $this->cachedResources[$name] = $resource;
    }

    return $resource;
  }

  public function getResources(): array
  {
    return $this->resources;
  }

  public function addResources(array $resources): self
  {
    $this->resources[] += $resources;

    return $this;
  }

  public function addAlias(string $key, string $value): self
  {
    $this->resourceAliases[$key] = $value;

    return $this;
  }

  public function addAliases(array $aliases): self
  {
    $this->resourceAliases[] += $aliases;

    return $this;
  }

  /**
   * Some of the dependencies given in $resources are
   * not turned into ContainerResources yet.
   * This function calls getResource on those dependencies.
   */
  private function resolveUncachedDependencies(ContainerResourceInterface $resource)
  {
    foreach ($resource->getParameters() as $key => $value) {
      if (class_exists($value)) {
        $resource->setParameter($key, $this->getResource($value));
      }
    }
  }

  private function getResourceWithAlias(string $name): ?ContainerResourceInterface
  {
    if (!array_key_exists($name, $this->resourceAliases)) {
      // TODO: Maybe throw NotFoundException here? 'Unaliased Interface'
      throw new NotFoundException("No alias found for interface: '{$name}'.");
    }

    $resourceToRetrieve = $this->resourceAliases[$name];

    if (array_key_exists($resourceToRetrieve, $this->cachedResources)) {
      return $this->cachedResources[$resourceToRetrieve];
    }

    $resource = $this->getResource($resourceToRetrieve);
    // adding Interface as key for new resource too,
    // instead of just the actual class.
    $this->cachedResources[$name] = $resource;

    return $resource;
  }
}