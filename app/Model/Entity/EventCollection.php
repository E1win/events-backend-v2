<?php
namespace App\Model\Entity;

use Framework\Model\Entity\Collection;
use Framework\Model\Entity\Contract\HasId;

class EventCollection extends Collection
{
  protected function buildEntity(): HasId
  {
    return new Event();
  }
}