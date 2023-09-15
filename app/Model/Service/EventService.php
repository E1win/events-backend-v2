<?php
namespace App\Model\Service;

use App\Model\Entity\Event;
use App\Model\Mapper\Event as EventMapper;
use DateTimeImmutable;

class EventService
{
  private $mapper;

  public function __construct(EventMapper $mapper)
  {
    $this->mapper = $mapper;
  }

  public function createEvent(string $name): Event
  {
    $event = new Event();
    $event->setCreatedOn(new DateTimeImmutable);
    $event->setName($name);

    $this->mapper->store($event);

    return $event;
  }

  public function getEventById(int $id): Event
  {
    $event = new Event($id);

    $this->mapper->fetch($event);

    return $event;
  }
}