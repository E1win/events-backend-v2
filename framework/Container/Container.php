<?php
namespace Framework\Container;

use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Framework\Container\Contract\MutableResourceCollection;
use Framework\Container\Exception\NotFoundException;
use Framework\Container\Resource\ContainerResourceCollection;
use Framework\Container\Resource\ResourceResolver;
use Psr\Container\ContainerInterface;

// https://medium.com/tech-tajawal/dependency-injection-di-container-in-php-a7e5d309ccc6
// https://github.com/PHP-DI/PHP-DI/tree/master

class Container implements ContainerInterface
{
  private $containerName = 'Container';

  private ContainerResourceCollectionInterface $resourceCollection;

  private ResourceResolver $resourceResolver;
  
  protected array $resolvedResources = [];

  static public function createWithDefaultConfiguration()
  {
    $config = config('di/', true);
    $aliases = config('aliases.php', true);

    $resourceCollection = new ContainerResourceCollection($config);

    $resourceCollection->addAliases($aliases);

    return new Container($resourceCollection);
  }

  public function __construct(
    ContainerResourceCollectionInterface $resourceCollection,
  ) {
    $this->resourceCollection = $resourceCollection;

    $this->resourceResolver = new ResourceResolver();

    $this->resolvedResources[Container::class] = $this;
    $this->resolvedResources[ContainerInterface::class] = $this;
  }

  public function get(string $name)
  {
    if (array_key_exists($name, $this->resolvedResources)) {
      return $this->resolvedResources[$name];
    }
    
    $resource = $this->resourceCollection->getResource($name);

    if ($resource == null) {
      throw new NotFoundException("Resource {$name} not found in {$this->containerName}");
    }

    $resolvedResource = $this->resourceResolver->resolve($resource);

    $this->resolvedResources[$name] = $resolvedResource;

    return $resolvedResource;
  }
  
  public function has(string $name): bool
  {
    if (array_key_exists($name, $this->resolvedResources)) {
      return true;
    }

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