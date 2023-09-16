<?php
namespace Framework\Model\Entity;

abstract class Entity
{
  public function toArray(): array
  {
    return get_object_vars($this);
  }
}