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

    $image = null;
    if ($event->getImageId() != null) {
      $image = $this->imageService->loadBase64EncodedImageById($event->getImageId());
    }

    $eventArray = $event->toArray();

    $eventArray['image_url'] = $image;

    return $this->view->load('event.html', $request, [
      'event' => $eventArray,
    ]);
  }

  public function store(ServerRequestInterface $request): ResponseInterface
  {
    /**
     * TODO: Function to verify form data.
     * Maybe also function to verify/retrieve images
     * Probably avoid logic in Controllers
     */

    $body = $request->getParsedBody();

    $files = $request->getUploadedFiles();

    $image = null;
    if (count($files) !== 0) {
      $image = $files[0];
    }

    $event = $this->eventService->createEvent($body['name'], $image);

    return $this->view->load('events.html');
  }
}