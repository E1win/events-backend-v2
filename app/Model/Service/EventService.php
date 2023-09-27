<?php
namespace App\Model\Service;

use App\Model\Entity\Event;
use App\Model\Entity\EventCollection;
use App\Model\Mapper\Event as EventMapper;
use App\Model\Mapper\EventCollection as EventCollectionMapper;
use DateTimeImmutable;

class EventService
{
  public function __construct(
    private EventMapper $mapper,
    private EventCollectionMapper $collectionMapper
  ) { }

  public function createEvent(string $name): Event
  {
    $event = new Event();
    $event->setCreatedOn(new DateTimeImmutable);
    $event->setName($name);

    $this->mapper->create($event);

    return $event;
  }

  public function getEventById(int $id): Event
  {
    $event = new Event($id);

    $this->mapper->read($event);

    return $event;
  }

  public function getAllEvents(): EventCollection
  {
    $collection = new EventCollection();
    $this->collectionMapper->read($collection);

    return $collection;
  }
}