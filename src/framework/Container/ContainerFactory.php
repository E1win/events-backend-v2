<?php
namespace Framework\Container;

class ContainerFactory
{
  private string $containerName;

  public function __construct(string $containerName = Container::class)
  {
    $this->containerName = $containerName;
  }

  /**
   * Create and return a container
   */
  public function create()
  {

  }
}