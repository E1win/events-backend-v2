<?php
namespace App\Model\Entity;

use Framework\Model\Entity\Entity;

class Participant extends Entity
{
  protected ?int $id;
  protected int $eventId;
  protected int $userId;

  public function __construct(?int $id = null)
  {
    $this->id = $id;
  }

  public function setId(int $id)
  {
    $this->id = $id;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function setEventId(int $id)
  {
    $this->eventId = $id;
  }

  public function getEventId(): int
  {
    return $this->eventId;
  }

  public function setUserId(int $id)
  {
    $this->userId = $id;
  }

  public function getUserId(): int
  {
    return $this->userId;
  }
}