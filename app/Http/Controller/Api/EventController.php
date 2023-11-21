<?php
namespace App\Http\Controller\Api;

use App\Model\Entity\Event;
use App\Model\Service\EventService;
use App\Model\Service\ImageService;
use Exception;
use Framework\Controller\Controller;
use Framework\Message\Contract\JsonResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventController extends Controller
{
  public function __construct(
    private JsonResponseFactoryInterface $responseFactory,    
    private EventService $eventService,
    private ImageService $imageService
  ) {}

  public function index(ServerRequestInterface $request): ResponseInterface
  {
    $events = $this->eventService->getAllEvents();

    return $this->responseFactory->createJsonResponse(
      $events
    );
  }

  public function show(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $event = $this->eventService->getEventById($id);

    $this->eventService->addImageUrlToEventEntity($event);
    $this->eventService->addParticipantsToEventEntity($event);

    return $this->responseFactory->createJsonResponse(
      $event,
    );
  }

  /**
   * Make user join event.
   */
  public function join(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $event = $this->eventService->getEventById($id);

    $user = $request->getAttribute('user');

    $this->eventService->addEventRegistration($event, $user->getId());

    return $this->responseFactory->createJsonResponse(
      $event,
    );
  }

  public function upcoming(ServerRequestInterface $request, ?int $amount = null): ResponseInterface
  {
    if ($amount == null) {
      // Get all upcoming events
      $events = $this->eventService->getAllUpcomingEvents();
    } else {
      // Get a number of upcoming events
      $events = $this->eventService->getUpcomingEventsByAmount($amount);

    }

    return $this->responseFactory->createJsonResponse(
      $events
    );
  }

  public function store(ServerRequestInterface $request): ResponseInterface
  {
    $body = $request->getParsedBody();

    $files = $request->getUploadedFiles();

    $image = null;
    if (count($files) !== 0) {
      $image = $files[0];
    }

    $event = $this->eventService->createEvent($body, $image);
    
    return $this->responseFactory->createJsonResponse(
      $event,
    );
  }

  public function update(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $body = $request->getParsedBody();

    $files = $request->getUploadedFiles();

    $image = null;
    if (count($files) !== 0) {
      $image = $files[0];
    }

    $event = $this->eventService->updateEvent($id, $body, $image);

    return $this->responseFactory->createJsonResponse(
      $this->formatEventArrayWithImageUrl($event),
    );
  }

  public function markEventCompleted(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $body = $request->getParsedBody();

    $completed = $body['completed'];

    $event = $this->eventService->markEventCompletedById($id, $completed);

    return $this->responseFactory->createJsonResponse(
      $this->formatEventArrayWithImageUrl($event),
    );
  }

  public function delete(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $event = $this->eventService->deleteEventById($id);

    return $this->responseFactory->createJsonResponse(
      ['success' => "Event with id '{$id}' succesfully deleted."],
    );
  }

  public function participants(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $participants = $this->eventService->getParticipantsByEventId($id);

    return $this->responseFactory->createJsonResponse(
      $participants
    );
  }

  private function formatEventArrayWithImageUrl(Event $event): array
  {
    $imageUrl = $event->getImageId() != null ? $this->imageService->loadImageUrlById($event->getImageId()) : null;

    $eventArray = $event->toArray();

    $eventArray['image_url'] = $imageUrl;

    return $eventArray;
  }
}