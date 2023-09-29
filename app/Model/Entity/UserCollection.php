<?php
namespace App\Model\Entity;

use Framework\Model\Entity\Collection;
use Framework\Model\Entity\Contract\HasId;

class UserCollection extends Collection
{
  protected function buildEntity(): HasId
  {
    return new User();
  }
}