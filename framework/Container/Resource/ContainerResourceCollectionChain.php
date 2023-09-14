<?php
namespace Framework\Container\Resource;

use Framework\Container\Contract\ContainerResourceCollectionInterface;
use Framework\Container\Contract\ContainerResourceInterface;

class ContainerResourceCollectionChain implements ContainerResourceCollectionInterface
{
  /**
   * @var ContainerResourceCollectionInterface[]
   */
  private array $resourceCollections;

  public function __construct(array $resourceCollections)
  {
    $this->resourceCollections = $resourceCollections;
  }

  public function getResource(string $name): ?ContainerResourceInterface
  {
    foreach ($this->resourceCollections as $resourceCollection) {
      var_dump($resourceCollection);
      echo '<br><br><br>';
    }
    // loop through resource resourceCollections
    return null;
  }

  public function getResources(): array
  {
    // TODO: later
    return [];
  }
}