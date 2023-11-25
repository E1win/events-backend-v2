<?php
namespace Framework\Auth\Model\Entity;

use Framework\Model\Entity\Entity;

class User extends Entity
{
  protected ?int $id;

  protected ?string $email = null;
  protected ?string $password = null;

  protected ?string $firstName = null;
  protected ?string $prefix = null;
  protected ?string $lastName = null;

  protected ?string $sessionUuid = null;
  protected ?int $expiresOn = null;

  protected ?bool $activeAccount = null;
  protected ?int $roleId = null;

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
    return password_verify($password, $this->password);
  }
  
  public function setFirstName(string $firstName)
  {
    $this->firstName = $firstName;
  }

  public function getFirstName()
  {
    return $this->firstName;
  }

  public function setPrefix(?string $prefix)
  {
    $this->prefix = $prefix;
  }

  public function getPrefix()
  {
    return $this->prefix;
  }

  public function setLastName(string $lastName)
  {
    $this->lastName = $lastName;
  }
  
  public function getLastName()
  {
    return $this->lastName;
  }

  public function getFullName()
  {
    if ($this->firstName == null || $this->lastName == null) {
      return null;
    }

    if (isset($this->prefix)) {
      return $this->firstName . ' ' . $this->prefix . ' ' . $this->lastName;
    }

    return $this->firstName . ' ' . $this->lastName;
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

  public function setActiveAccount(bool $activeAccount)
  {
    $this->activeAccount = $activeAccount;
  }

  public function getActiveAccount()
  {
    return $this->activeAccount;
  }

  public function setRoleId(string $roleId)
  {
    $this->roleId = $roleId;
  }

  public function getRoleId()
  {
    return $this->roleId;
  }

  /**
   * Unsets all sensitive data. (ex: passwords)
   */
  public function unsetSensitiveData()
  {
    $this->password = null;
    $this->sessionUuid = null;
  }

  public function withoutSensitiveData(): User
  {
    $clone = clone $this;

    $clone->unsetSensitiveData();
    
    return $clone;
  }
}