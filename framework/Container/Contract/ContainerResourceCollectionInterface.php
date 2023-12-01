<?php
namespace Framework\Container\Contract;

interface ContainerResourceCollectionInterface
{
  /**
   * Returns the DI definition for entry name.
   */
  public function getResource(string $name): ContainerResourceInterface;

  /**
   * Returns an array of definitions indexed by their names.
   */
  public function getResources(): array;
}