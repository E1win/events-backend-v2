<?php
namespace App\Model\Entity;

use Framework\Model\Entity\Collection;
use Framework\Model\Entity\Contract\HasId;

class EventCollection extends Collection
{
  protected ?bool $completed = null;

  protected function buildEntity(): HasId
  {
    return new Event();
  }

  public function forCompleted(bool $completed)
  {
    $this->completed = $completed;
  }

  public function getCompleted(): ?bool
  {
    return $this->completed;
  }
}