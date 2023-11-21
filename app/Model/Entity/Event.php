<?php
namespace App\Model\Entity;

use DateTimeImmutable;
use Framework\Model\Entity\Entity;

class Event extends Entity
{
  protected ?int $id = null;
  protected $name = null;
  protected $description = null;
  protected ?string $location = null;

  protected ?DateTimeImmutable $date = null;
  protected ?string $startTime = null;
  protected ?string $endTime = null;

  protected ?int $imageId = null;
  protected ?bool $completed = false;

  protected ?string $imageUrl = null;
  protected ?array $participants = null;

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

  public function setImageUrl(string $imageUrl)
  {
    $this->imageUrl = $imageUrl;
  }

  public function getImageUrl()
  {
    return $this->imageUrl;
  }

  public function setParticipants(array $participants)
  {
    $this->participants = $participants;
  }

  public function getParticipants()
  {
    return $this->participants;
  }
}