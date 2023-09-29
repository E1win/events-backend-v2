<?php
namespace App\Model\Entity;

use Framework\Model\Entity\Entity;

class User extends Entity
{
  protected ?int $id;
  protected string $name;
  protected string $email;

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

  public function setName(string $name)
  {
    $this->name = $name;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function setEmail(string $email)
  {
    $this->email = $email;
  }

  public function getEmail(): string
  {
    return $this->email;
  }
}