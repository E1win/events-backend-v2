<?php
namespace App\Model\Entity;

use DateTimeImmutable;
use Framework\Model\Entity\Entity;

class Event extends Entity
{
  protected ?int $id;
  protected $name;
  protected $description;
  protected ?string $location;

  protected ?DateTimeImmutable $date;
  protected ?string $startTime;
  protected ?string $endTime;

  protected ?int $imageId;
  protected ?bool $completed;

  public function __construct(?int $id = null)
  {
    $this->id = $id;
  }

  public function setId(int $id)
  {
    $this->id = $id;
  }

  public function getId(): ?int
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

  public function setDescription(string $description)
  {
    $this->description = $description;
  }

  public function getDescription()
  {
    return $this->description;
  }

  public function setLocation(string $location)
  {
    $this->location = $location;
  }

  public function getLocation()
  {
    return $this->location;
  }

  public function setDate(DateTimeImmutable $date)
  {
    $this->date = $date;
  }

  public function getDate(): DateTimeImmutable
  {
    return $this->date;
  }

  public function setStartTime(string $startTime)
  {
    $this->startTime = $startTime;
  }

  public function getStartTime()
  {
    return $this->startTime;
  }

  public function setEndTime(string $endTime)
  {
    $this->endTime = $endTime;
  }

  public function getEndTime()
  {
    return $this->endTime;
  }

  public function setImageId(?int $id)
  {
    $this->imageId = $id;
  }

  public function getImageId(): ?int
  {
    return $this->imageId;
  }

  public function setCompleted(bool $completed)
  {
    $this->completed = $completed;
  }

  public function getCompleted()
  {
    return $this->completed;
  }
}