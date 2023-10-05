<?php
namespace App\Model\Entity\Auth;

use DateTimeImmutable;
use Framework\Model\Entity\Entity;

class Session extends Entity
{
  protected int $id;
  protected $sessionUuid;
  protected int $userId;
  protected $expiresOn;

  public function setId(int $id)
  {
    $this->id = $id;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function setSessionUuid(string $sessionUuid)
  {
    $this->sessionUuid = $sessionUuid;
  }

  public function getSessionUuid()
  {
    return $this->sessionUuid;
  }

  public function setUserId(int $userId)
  {
    $this->userId = $userId;
  }

  public function getUserId()
  {
    return $this->userId;
  }

  public function setExpiresOn(int $expiresOn)
  {
    $this->expiresOn = $expiresOn;
  }

  public function getExpiresOn()
  {
    return $this->expiresOn;
  }

  public function isExpired(): bool
  {
    echo time();
    echo '<br>';
    echo $this->expiresOn;
    return time() > $this->expiresOn;
  }
}