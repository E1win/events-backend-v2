<?php
namespace App\Http\Controller;

use App\Model\Service\EventService;
use Framework\Controller\Controller;
use Framework\Message\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventController extends Controller
{
  private EventService $eventService;

  public function __construct(EventService $eventService)
  {
    $this->eventService = $eventService;
  }

  public function show(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $event = $this->eventService->getEventById($id);

    var_dump($event->toArray());
    return Response::json(
      $event->toArray()
    );
  }
}