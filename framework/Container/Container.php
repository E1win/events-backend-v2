<?php
namespace Framework\Container;

use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Framework\Container\Exception\NotFoundException;
use Psr\Container\ContainerInterface;

// https://medium.com/tech-tajawal/dependency-injection-di-container-in-php-a7e5d309ccc6
// https://github.com/PHP-DI/PHP-DI/tree/master

class Container implements ContainerInterface
{
  private $containerName = 'Container';

  private ?ContainerInterface $parentContainer;

  private ContainerResourceCollectionInterface $resourceCollection;
  
  protected array $resolvedResources = [];

  /**
   * Use `$container = new Container()` for default configuration.
   * 
   * Otherwise use ContainerFactory class to customize the config.
   */
  public function __construct(
    ContainerResourceCollectionInterface $resourceCollection,
    ContainerInterface|null $parentContainer
  ) {
    $this->resourceCollection = $resourceCollection;
    $this->parentContainer = $parentContainer;
  }

  public function get(string $name)
  {
    if (array_key_exists($name, $this->resolvedResources)) {
      return $this->resolvedResources[$name];
    }

    // if can't find here, try parent container
    // so for example: this container has ReflectionAutowiring
    // as it's ContainerResourceCollection.
    // if that doesn't work (so if it has dependency with primitive parameter)
    // parent get's called with more definitions to try there.

    // then also call get on parameters if it's a class

    
    $resource = $this->resourceCollection->getResource($name);

    if ($resource == null) {
      throw new NotFoundException("Resource {$name} not found in {$this->containerName}");
    }

    // Does it have class dependencies?
    // Call this->get on those.

    // after that,
    // resolve it.


    return $resource;

    // if ($resource == null) {
    //   if ($this->parentContainer != null) {
    //     $resource = $this->parentContainer->get($name);
    //   } else {
    //     throw new NotFoundException("Resource {$name} not found in {$this->containerName}");
    //   }
    // }

    // After resource is returned, use a resolver to instantiate object
  }
  
  public function has(string $name): bool
  {
    if (array_key_exists($name, $this->resolvedResources)) {
      return true;
    }

    $resource = $this->resourceCollection->getResource($name);

    if ($resource == null && $this->parentContainer != null) {
      return $this->parentContainer->has($name);
    }

    return false;
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
}