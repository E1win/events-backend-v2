<?php
namespace App\Model\Entity;

use Framework\Model\Entity\Entity;

class Image extends Entity
{
  protected ?int $id;
  public ?string $name = null;
  public ?string $contentType = null;

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

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setContentType(string $contentType)
  {
    $this->contentType = $contentType;
  }

  public function getContentType(): ?string
  {
    return $this->contentType;
  }
}