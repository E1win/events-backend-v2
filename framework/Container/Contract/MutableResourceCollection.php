<?php
namespace Framework\Container\Contract;

interface MutableResourceCollection extends ContainerResourceCollectionInterface
{
  public function addResources(array $resources): self;

  public function addAlias(string $key, string $value): self;
}