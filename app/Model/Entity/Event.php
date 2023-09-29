<?php
namespace App\Model\Entity;

use DateTimeImmutable;
use Framework\Model\Entity\Entity;

class Event extends Entity
{
  protected ?int $id;
  protected $name;
  protected $createdOn;
  protected ?int $imageId;

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

  public function getName()
  {
    return $this->name;
  }

  public function setCreatedOn(DateTimeImmutable $createdOn)
  {
    $this->createdOn = $createdOn;
  }

  public function getCreatedOn(): DateTimeImmutable
  {
    return $this->createdOn;
  }

  public function setImageId(?int $id)
  {
    $this->imageId = $id;
  }

  public function getImageId(): ?int
  {
    return $this->imageId;
  }
}