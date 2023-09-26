<?php
namespace Framework\Model\Entity;

use Framework\Model\Entity\Contract\HasId;
use Framework\Model\Entity\Contract\Arrayable;
use Framework\Model\Entity\Contract\Entity as ContractEntity;
use JsonSerializable;

abstract class Entity implements ContractEntity
{
  public function toArray(): array
  {
    return get_object_vars($this);
  }

  public function jsonSerialize(): mixed
  {
    return get_object_vars($this);
  }
}