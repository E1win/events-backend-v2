<?php
namespace Framework\Container;

use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Psr\Container\ContainerInterface;

// https://medium.com/tech-tajawal/dependency-injection-di-container-in-php-a7e5d309ccc6
// https://github.com/PHP-DI/PHP-DI/tree/master

class Container implements ContainerInterface
{
  private ?ContainerInterface $parentContainer;

  protected array $resolvedResources = [];

  private ContainerResourceCollectionInterface $containerResourceCollection;

  /**
   * Use `$container = new Container()` for default configuration.
   * 
   * Otherwise use ContainerFactory class to customize the config.
   */
  public function __construct(ContainerInterface|null $parentContainer, ContainerResourceCollectionInterface $containerResourceCollection)
  {
    $this->containerResourceCollection = $containerResourceCollection;
    $this->parentContainer = $parentContainer;
  }

  public function get(string $id)
  {
    if (array_key_exists($id, $this->resolvedResources)) {
      return $this->resolvedResources[$id];
    }

    // if can't find here, try parent container
    // so for example: this container has ReflectionAutowiring
    // as it's ContainerResourceCollection.
    // if that doesn't work (so if it has dependency with primitive parameter)
    // parent get's called with more definitions to try there.

    // After resource is returned, use a resolver to instantiate object
    
    $definition = $this->getDefinition($id);
  }
  
  public function has(string $id): bool
  {
    // if can't find here, try parent container
    
    return false;
  }

  protected function getDefinition(string $name)
  {
    // use containerResourceCollection to try to find definition
  }
}