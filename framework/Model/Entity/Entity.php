<?php
namespace Framework\Model\Entity;

use Framework\Model\Entity\Contract\HasId;
use Framework\Model\Entity\Contract\Arrayable;
use JsonSerializable;

abstract class Entity implements HasId, Arrayable, JsonSerializable
{
  public function toArray(): array
  {
    return get_object_vars($this);
  }

  public function jsonSerialize(): mixed
  {
    return $this->toArray();
  }
}