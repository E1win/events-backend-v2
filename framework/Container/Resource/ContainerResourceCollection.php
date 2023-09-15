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

  /**
   * @var ContainerResourceInterface[] $cachedResources
   */
  protected array $cachedResources = [];

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
    echo "<br><br>RESOLVING: {$name}<br>";

    if (array_key_exists($name, $this->cachedResources)) {

      echo "<br><br>VALUE TAKEN FROM CACHE:<br>";
      var_dump($this->cachedResources[$name]);
      echo "<br><br><br>";

      return $this->cachedResources[$name];
    }

    if (array_key_exists($name, $this->resources)) {

      $resource = $this->resources[$name];

      echo "<br><br>VALUE TAKEN FROM RESOURCES:<br>";
      var_dump($this->resources[$name]);

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

  private function resolveUncachedDependencies(ContainerResourceInterface $resource)
  {
    foreach ($resource->getParameters() as $key => $value) {
      if (class_exists($value)) {
        echo "UNCACHED DEPENDENCY: {$value}, key: {$key}";
        $resource->setParameter($key, $this->getResource($value));
      }
    }
  }
}