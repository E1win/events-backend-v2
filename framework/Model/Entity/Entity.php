<?php
namespace Framework\Model\Entity;

use Framework\Model\Entity\Contract\HasId;
use Framework\Model\Entity\Contract\ToArray;

abstract class Entity implements HasId, ToArray
{
  public function toArray(): array
  {
    return get_object_vars($this);
  }
}