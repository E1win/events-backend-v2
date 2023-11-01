<?php
namespace App\Model\Entity;

use Framework\Model\Entity\Collection;
use Framework\Model\Entity\Contract\HasId;

class EventCollection extends Collection
{
  protected ?bool $completed = null;
  protected ?bool $upcoming = null;
  protected ?int $amount = null;

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

  public function forUpcoming(bool $upcoming)
  {
    $this->upcoming = $upcoming;
  }

  public function getUpcoming(): ?bool
  {
    return $this->upcoming;
  }

  public function forAmount(int $amount)
  {
    $this->amount = $amount;
  }

  public function getAmount(): ?int
  {
    return $this->amount;
  }
}