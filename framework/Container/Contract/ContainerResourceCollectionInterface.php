<?php
namespace Framework\Container\Contract;

interface ContainerResourceCollectionInterface
{
  /**
   * Returns the DI definition for entry name.
   * 
   * TODO: add return type
   */
  public function getResource(string $name): ContainerResourceInterface|null;

  /**
   * Returns an array of definitions indexed by their names.
   */
  public function getResources(): array;
}