<?php
namespace App\Http\Controller\Web;

use App\Model\Service\EventService;
use App\Model\Service\ImageService;
use Framework\Controller\Controller;
use Framework\View\Contract\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class EventController extends Controller
{
  public function __construct(
    private EventService $eventService,
    private ImageService $imageService,
    private ViewRenderer $view,
  ) {}

  public function index(ServerRequestInterface $request): ResponseInterface
  {
    $events = $this->eventService->getAllEvents();

    return $this->view->load('events.html', $request, [
      'events' => $events->toArray(),
    ]);
  }

  public function show(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $event = $this->eventService->getEventById($id);

    return $this->view->load('event.html', $request, [
      'event' => $event,
    ]);
  }
}