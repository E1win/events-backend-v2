<?php
namespace Framework\Model\Entity;

use Framework\Model\Entity\Contract\HasId;
use Framework\Model\Entity\Contract\Arrayable;

abstract class Entity implements HasId, Arrayable
{
  public function toArray(): array
  {
    return get_object_vars($this);
  }
}