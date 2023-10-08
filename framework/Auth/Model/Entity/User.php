<?php
namespace Framework\Auth\Model\Entity;

use Framework\Model\Entity\Entity;

class User extends Entity
{
  protected ?int $id;
  protected ?string $email = null;
  protected ?string $password = null;

  protected ?string $sessionUuid = null;
  protected ?int $expiresOn = null;

  public function __construct(?int $id = null)
  {
    $this->id = $id;
  }

  public function setId(int $id)
  {
    $this->id = $id;
  }

  public function getId()
  {
    return $this->id;
  }

  public function setEmail(string $email)
  {
    $this->email = $email;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setPassword(string $password)
  {
    $this->password = $password;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function matchPassword(string $password): bool
  {
    return true;
  }

  public function setSessionUuid(string $sessionUuid)
  {
    $this->sessionUuid = $sessionUuid;
  }

  public function getSessionUuid()
  {
    return $this->sessionUuid;
  }

  public function setExpiresOn(int $expiresOn)
  {
    $this->expiresOn = $expiresOn;
  }

  public function getExpiresOn()
  {
    return $this->expiresOn;
  }

  public function isSessionExpired(): bool
  {
    return time() > $this->expiresOn;
  }
}