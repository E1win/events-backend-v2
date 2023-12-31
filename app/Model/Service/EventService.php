<?php
namespace App\Model\Service;

use App\Model\Entity\Event;
use App\Model\Entity\EventCollection;
use App\Model\Mapper\Event as EventMapper;
use App\Model\Mapper\EventCollection as EventCollectionMapper;
use DateTimeImmutable;
use Exception;
use Framework\Auth\Model\Entity\User;
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

  public function eventExists(int $id): bool
  {
    $event = new Event();
    $event->setId($id);

    return $this->mapper->exists($event);
  }

  public function createEvent(array $body, ?UploadedFileInterface $image = null): Event
  {
    $event = new Event();
    $event->setName($body['name']);
    $event->setDescription($body['description']);
    $event->setDate(new DateTimeImmutable($body['date']));
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

  public function updateEvent(int $id, array $body, ?UploadedFileInterface $image = null): Event
  {
    $event = $this->getEventById($id);

    $event->setName($body['name']);
    $event->setDescription($body['description']);
    $event->setDate(new DateTimeImmutable($body['date']));
    $event->setStartTime($body['startTime']);
    $event->setEndTime($body['endTime']);
    $event->setLocation($body['location']);

    if (isset($body['completed'])) {
      $event->setCompleted($body['completed']);
    }

    if ($image != null) {
      $prevImageId = $event->getImageId();

      $image = $this->imageService->uploadImage($image);
      $event->setImageId($image->getId());
    }

    // TODO: Updating / deleting old image definitely should be refactored.

    $this->mapper->store($event);

    if ($image != null && $prevImageId != null) {
      $this->imageService->deleteImageById($prevImageId);
    }

    $this->addImageUrlToEventEntity($event);

    return $event;
  }

  public function markEventCompletedById(int $id, bool $completed): Event
  {
    $event = $this->getEventById($id);

    $event->setCompleted($completed);

    $this->mapper->store($event);

    return $event;
  }

  public function deleteEventById(int $id): Event
  {
    $event = $this->getEventById($id);

    $this->mapper->delete($event);

    return $event;
  }

  public function getEventById(int $id): Event
  {
    $event = new Event($id);

    $this->mapper->fetch($event);

    $this->addImageUrlToEventEntity($event);
    $this->addParticipantsToEventEntity($event);

    return $event;
  }

  public function getAllEvents(): EventCollection
  {
    $collection = new EventCollection();
    $this->collectionMapper->fetch($collection);

    return $collection;
  }

  /**
   * Adds things like image_url to event,
   * and participants
   */
  public function addImageUrlToEventEntity(Event $event): Event
  {
    if ($event->getImageId() != null) {
      $url = $this->imageService->loadImageUrlById($event->getImageId());
      $event->setImageUrl($url);
    }

    return $event;
  }

  public function addParticipantsToEventEntity(Event $event): Event
  {
    $participants = $this->participantService->getParticipantsByEventId($event->getId());

    $users = new UserCollection();

    foreach ($participants as $participant) {
      $id = $participant->getUserId();
      $user = $this->userService->getUserById($id);
      $users->addEntity($user);
    }

    $event->setParticipants($users->toArray());

    return $event;
  }

  public function isUserRegisteredToEvent(int $eventId, int $userId): bool
  {
    return $this->participantService->registrationExists($eventId, $userId);;
  }

  public function addEventRegistration(Event $event, User $user): Event
  {
    $this->participantService->addRegistration($event->getId(), $user->getId());

    $event->addParticipant($user->toArray());

    return $event;
  }

  public function removeEventRegistration(Event $event, User $user): Event
  {
    $this->participantService->removeRegistration($event->getId(), $user->getId());

    $event->removeParticipant($user->toArray());

    return $event;
  }

  public function getAllUpcomingEvents(): EventCollection
  {
    $collection = new EventCollection();
    $collection->forUpcoming(true);
    $this->collectionMapper->fetch($collection);

    return $collection;
  }

  public function getUpcomingEventsByAmount(int $amount): EventCollection
  {
    $collection = new EventCollection();
    $collection->forUpcoming(true);
    $collection->forAmount($amount);
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