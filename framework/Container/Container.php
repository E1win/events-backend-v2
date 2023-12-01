<?php
namespace Framework\Container;

use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Framework\Container\Contract\ContainerResourceInterface;
use Framework\Container\Contract\MutableResourceCollection;
use Framework\Container\Exception\NotFoundException;
use Framework\Container\Resource\ContainerResourceCollection;
use Framework\Container\Resource\ResourceResolver;
use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
  private $containerName = 'Container';

  private ContainerResourceCollectionInterface $resourceCollection;

  private ResourceResolver $resourceResolver;
  
  static public function createWithDefaultConfiguration()
  {
    $config = config('di/', true);
    $aliases = config('interface-aliases.php', true);

    $resourceCollection = new ContainerResourceCollection($config);

    $resourceCollection->addAliases($aliases);

    return new Container($resourceCollection);
  }

  public function __construct(
    ContainerResourceCollectionInterface $resourceCollection,
  ) {
    $this->resourceCollection = $resourceCollection;

    $this->resourceResolver = new ResourceResolver($this);
  }

  public function get(string $name)
  {
    // Get ContainerResource using name
    $resource = $this->resourceCollection->getResource($name);

    // Resolve ContainerResource into an instance
    return $this->resourceResolver->resolve($resource);
  }
  
  public function has(string $name): bool
  {
    try {
      $resource = $this->resourceCollection->getResource($name);
    } catch (\Throwable $th) {
      return false;
    }

    if ($resource == null) {
      return false;
    } else {
      return true;
    }
  }

  public function setName(string $name): self
  {
    $this->containerName = $name;

    return $this;
  }

  public function getName(): string
  {
    return $this->containerName;
  }

  public function getResourceCollection(): MutableResourceCollection
  {
    return $this->resourceCollection;
  }
}