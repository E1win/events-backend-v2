<?php
namespace Framework\Auth\Model\Entity;

use Framework\Model\Entity\Entity;

class Role extends Entity
{
  const DEFAULT = 1;
  const ADMIN = 2;
  const OWNER = 3;

  protected ?int $id;
  protected ?string $name;

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

  public function setName(string $name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }

}