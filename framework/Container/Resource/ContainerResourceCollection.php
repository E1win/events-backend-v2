<?php
namespace Framework\Container\Resource;

use Framework\Container\Contract\AutowiringInterface;
use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Framework\Container\Contract\ContainerResourceInterface;
use Framework\Container\Exception\NotFoundException;

class ContainerResourceCollection implements ContainerResourceCollectionInterface
{
  private array $unprocessedResources;

  private array $cachedResources = [];

  private ?AutowiringInterface $autowiring;

  private array $resourceAliases = [];

  /**
   * @param ContainerResourceInterface[] $resources
   */
  public function __construct(
    array $unprocessedResources = [], 
    ?AutowiringInterface $autowiring = null
  ) {
    $this->unprocessedResources = $unprocessedResources;
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

    if (array_key_exists($name, $this->unprocessedResources)) {
      $parameters = $this->unprocessedResources[$name];
      
      $resource = $this->processResource($name, $parameters);
      
      return $this->cacheAndReturnResource($resource);
      // $this->cachedResources[$name] = $resource;
      // return $this->cachedResources[$name];
    }

    $resource = $this->autowiring->autowire($name);

    if ($resource == null) {
      return null;
      // $this->cachedResources[$name] = $resource;
    }

    return $this->cacheAndReturnResource($resource);
    // return $resource;
  }

  public function getResources(): array
  {
    return $this->unprocessedResources;
  }

  public function addResources(array $resources): self
  {
    $this->unprocessedResources[] += $resources;

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

    return $this->cacheAndReturnResource($resource, $name);
  }

  private function processResource($name, $parameters): ?ContainerResource
  {
    $resource = $this->createResource($name, $parameters);
    $this->resolveUnprocessedDependencies($resource);

    return $resource;
  }
  
  private function createResource($name, $parameters): ?ContainerResourceInterface
  {
    return ContainerResource::create($name, $parameters);
  }

  /**
   * Some of the dependencies of a resource might
   * not be turned into ContainerResources yet.
   * This function calls getResource on those dependencies.
   */
  private function resolveUnprocessedDependencies(ContainerResourceInterface $resource)
  {
    foreach ($resource->getParameters() as $key => $value) {
      if (class_exists($value)) {
        $resource->setParameter($key, $this->getResource($value));
      }
    }
  }

  private function cacheAndReturnResource(ContainerResourceInterface $resource, ?string $name = null): ContainerResourceInterface
  {
    if ($name === null) {
      $name = $resource->getName();
    }

    $this->cachedResources[$name] = $resource;
    return $this->cachedResources[$name];
  }
}