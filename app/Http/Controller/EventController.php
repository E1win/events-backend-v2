<?php
namespace App\Http\Controller;

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

  public function show(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $event = $this->eventService->getEventById($id);

    return $this->responseFactory->createJsonResponse(
      $event->toArray()
    );
  }
}