<?php
namespace Framework\Container;

use Framework\Container\Contract\DefinitionSourceInterface;
use Psr\Container\ContainerInterface;

// https://medium.com/tech-tajawal/dependency-injection-di-container-in-php-a7e5d309ccc6
// https://github.com/PHP-DI/PHP-DI/tree/master

class Container implements ContainerInterface
{
  /**
   * Array of resolved entries to reduce,
   * so it's not necessary to do it twice
   */
  protected array $resolvedEntries = [];

  private DefinitionSourceInterface $definitionSource;

  /**
   * Use `$container = new Container()` for default configuration.
   * 
   * Otherwise use ContainerFactory class to customize the config.
   */
  public function __construct(DefinitionSourceInterface $definitions)
  {
    $this->definitionSource = $definitions;
  }

  public function get(string $id)
  {
    if (array_key_exists($id, $this->resolvedEntries)) {
      return $this->resolvedEntries[$id];
    }

    $definition = $this->getDefinition($id);
  }

  public function has(string $id): bool
  {
    
    return false;
  }

  protected function getDefinition(string $name)
  {
    // use definitionSource to try to find definition
  }
}