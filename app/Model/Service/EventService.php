<?php
namespace App\Model\Service;

use App\Model\Entity\Event;
use App\Model\Entity\EventCollection;
use App\Model\Mapper\Event as EventMapper;
use App\Model\Mapper\EventCollection as EventCollectionMapper;
use DateTimeImmutable;
use Framework\Auth\Model\Entity\UserCollection;
use Framework\Auth\Model\Service\UserService;
use Psr\Http\Message\UploadedFileInterface;

class EventService
{
  public function __construct(
    private EventMapper $mapper,
    private EventCollectionMapper $collectionMapper,
    private ParticipantService $participantService,
    private UserService $userService,
    private ImageService $imageService
  ) { }

  public function createEvent(array $body, ?UploadedFileInterface $image = null): Event
  {
    $event = new Event();
    $event->setName($body['name']);
    $event->setDescription($body['description']);
    $event->setDate(new DateTimeImmutable);
    $event->setStartTime($body['startTime']);
    $event->setEndTime($body['endTime']);
    $event->setLocation($body['location']);

    if ($image !== null) {
      $image = $this->imageService->uploadImage($image);
      $event->setImageId($image->getId());
    }

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

  public function getAllUpcomingEvents(): EventCollection
  {
    $collection = new EventCollection();
    $collection->forUpcoming(true);
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