<?php
namespace App\Model\Service;

use App\Model\Entity\Event;
use App\Model\Entity\EventCollection;
use App\Model\Entity\ParticipantCollection;
use App\Model\Entity\UserCollection;
use App\Model\Mapper\Event as EventMapper;
use App\Model\Mapper\EventCollection as EventCollectionMapper;
use DateTimeImmutable;

class EventService
{
  public function __construct(
    private EventMapper $mapper,
    private EventCollectionMapper $collectionMapper,
    private ParticipantService $participantService,
    private UserService $userService,
  ) { }

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

  public function getAllEvents(): EventCollection
  {
    $collection = new EventCollection();
    $this->collectionMapper->fetch($collection);

    return $collection;
  }

  public function getParticipantsByEventId(int $id): UserCollection
  {
    $participants = $this->participantService->getParticipantsByEventId($id);

    $users = new UserCollection();

    foreach ($participants as $participant) {
      $id = $participant->getUserId();
      $user = $this->userService->getUserById($id);
      $users->addEntity($user);
    }

    return $users;
  }
}