<?php
namespace Framework\Container\Contract;

interface DefinitionSourceInterface
{
  /**
   * Returns the DI definition for entry name.
   * 
   * TODO: add return type
   */
  public function getDefinition(string $name);

  /**
   * Returns an array of definitions indexed by their names.
   */
  public function getDefinitions(): array;
}