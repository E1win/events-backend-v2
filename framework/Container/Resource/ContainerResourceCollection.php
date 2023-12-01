<?php
namespace Framework\Container\Resource;

use Framework\Container\Contract\AutowiringInterface;
use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Framework\Container\Contract\ContainerResourceInterface;
use Framework\Container\Contract\MutableResourceCollection;
use Framework\Container\Exception\NotFoundException;

class ContainerResourceCollection implements ContainerResourceCollectionInterface, MutableResourceCollection
{
  private array $unprocessedResources = [];

  private array $processedResources = [];

  private AutowiringInterface $autowiring;

  private array $resourceAliases = [];

  /**
   * @param ContainerResourceInterface[] $resources
   */
  public function __construct(
    array $unprocessedResources, 
    ?AutowiringInterface $autowiring = null
  ) {
    $this->unprocessedResources = $unprocessedResources;

    if ($autowiring == null) {
      $this->autowiring = new ContainerResourceAutowirer($this);
    } else {
      $this->autowiring = $autowiring;
      $this->autowiring->setParent($this);
    }
  }

  public function getResource(string $name): ContainerResourceInterface
  {
    if (array_key_exists($name, $this->processedResources)) {
      return $this->processedResources[$name];
    }

    if (interface_exists($name)) {
      return $this->getResourceWithAlias($name);
    }
    
    if (array_key_exists($name, $this->unprocessedResources)) {
      $parameters = $this->unprocessedResources[$name];
      
      $resource = $this->processResource($name, $parameters);
      
      return $this->cacheAndReturnResource($resource);
    }


    if (! class_exists($name)) {
      throw new NotFoundException("Could not find class with name: '{$name}'.");
    }

    $resource = $this->autowiring->autowire($name);

    return $this->cacheAndReturnResource($resource);
  }

  public function getResources(): array
  {
    return $this->processedResources + $this->unprocessedResources;
  }

  public function addResources(array $resources = []): self
  {
    $this->unprocessedResources += $resources;

    return $this;
  }

  public function addAlias(string $key, string $value): self
  {
    $this->resourceAliases[$key] = $value;

    return $this;
  }

  public function addAliases(array $aliases): self
  {
    if (count($this->resourceAliases) == 0) {
      $this->resourceAliases = $aliases;
    } else {
      $this->resourceAliases[] += $aliases;
    }

    return $this;
  }
  
  private function getResourceWithAlias(string $interfaceName): ?ContainerResourceInterface
  {
    if (!array_key_exists($interfaceName, $this->resourceAliases)) {
      throw new NotFoundException("No class found for interface: '{$interfaceName}'.");
    }
    
    $className = $this->resourceAliases[$interfaceName];
    
    if (array_key_exists($className, $this->processedResources)) {
      return $this->processedResources[$className];
    }

    $resource = $this->getResource($className);

    // adding Interface as key for new resource too,
    // instead of just the actual class.
    return $this->cacheAndReturnResource($resource, $interfaceName);
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
      if (is_string($value) && class_exists($value)) {
        $resource->setParameter($key, $this->getResource($value));
      }
    }
  }

  private function cacheAndReturnResource(ContainerResourceInterface $resource, ?string $name = null): ContainerResourceInterface
  {
    if ($name === null) {
      $name = $resource->getName();
    }

    $this->processedResources[$name] = $resource;
    return $this->processedResources[$name];
  }
}