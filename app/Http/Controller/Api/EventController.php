<?php
namespace App\Http\Controller\Api;

use App\Model\Service\EventService;
use Framework\Controller\Controller;
use Framework\Message\Contract\JsonResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventController extends Controller
{
  public function __construct(
    private JsonResponseFactoryInterface $responseFactory,
    private EventService $eventService
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

    return $this->responseFactory->createJsonResponse(
      $event
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

  public function participants(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $participants = $this->eventService->getParticipantsByEventId($id);

    return $this->responseFactory->createJsonResponse(
      $participants
    );
  }
}