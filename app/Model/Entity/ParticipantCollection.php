<?php
namespace App\Model\Entity;

use Framework\Model\Entity\Collection;
use Framework\Model\Entity\Contract\HasId;

class ParticipantCollection extends Collection
{
  protected int $eventId;
  protected int $userId;

  protected function buildEntity(): HasId
  {
    return new Participant();
  }

  public function forEventId(int $id)
  {
    $this->eventId = $id;
  }

  public function getEventId(): int
  {
    return $this->eventId;
  }

  public function forUserId(int $id)
  {
    $this->userId = $id;
  }

  public function getUserId(): int
  {
    return $this->userId;
  }
}