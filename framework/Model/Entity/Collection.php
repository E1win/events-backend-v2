<?php
namespace Framework\Model\Entity;

use Framework\Model\Entity\Contract\HasId;
use Framework\Model\Entity\Contract\Arrayable;

abstract class Collection implements \Iterator, \ArrayAccess, \Countable, Arrayable
{
  abstract protected function buildEntity(): HasId; 

  private array $pool = [];

  private int $position = 0;
  private int $offset = 0;

  public function addBlueprint(array $parameters)
  {
    $instance = $this->buildEntity();
    $this->populateEntity($instance, $parameters);

    $this->addEntity($instance);

    return $instance;
  }

  private function populateEntity($instance, array $parameters)
  {
    foreach ($parameters as $key => $value) {
      $method = "set" . str_replace("_", '', $key);
      if (method_exists($instance, $method)) {
        $instance->{$method}($value);
      }
    }
  }

  public function addEntity(HasId $entity, ?int $key = null)
  {
    if ($key !== null) {
      $this->replaceEntity($entity, $key);
      return;
    }

    $this->pool[] = $entity;
  }

  private function replaceEntity(HasId $entity, int $key)
  {
    $this->pool[$key] = $entity;
  }

  public function removeEntityByOffset(int $offset)
  {
    if ($this->offsetExists($offset)) {
      unset($this->pool[$offset]);
    }
  }

  // Implementing Countable

  public function count(): int
  {
    return count($this->pool);
  }

  // Implementing Iterator

  public function current(): mixed
  {
    return $this->pool[$this->position];
  }

  public function next(): void
  {
    ++$this->position;
  }

  public function key(): mixed
  {
    return $this->position;
  }

  public function valid(): bool
  {
    return isset($this->pool[$this->position]);
  }

  public function rewind(): void
  {
    $this->position = 0;
  }

  // Implementing ArrayAccess

  public function offsetExists(mixed $offset): bool
  {
    return isset($this->pool[$this->offset]);
  }

  public function offsetGet(mixed $offset): mixed
  {
    return $this->pool[$offset] ?? null;
  }

  public function offsetSet(mixed $offset, mixed $value): void
  {
    $this->addEntity($value, $offset);
  }

  public function offsetUnset(mixed $offset): void
  {
    $this->removeEntityByOffset($offset);
  }

  // Implementing ToArray

  public function toArray(): array
  {
    return array_map(function(Entity $entity) {
      return $entity->toArray();
    }, $this->pool);
  }
}