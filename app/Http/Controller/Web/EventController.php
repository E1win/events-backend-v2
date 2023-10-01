<?php
namespace App\Http\Controller\Web;

use App\Model\Service\EventService;
use Framework\Controller\Controller;
use Framework\Message\Contract\HtmlResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class EventController extends Controller
{
  public function __construct(
    private EventService $eventService,
    private Environment $view,
    private HtmlResponseFactoryInterface $responseFactory,
  ) {}

  public function index(ServerRequestInterface $request): ResponseInterface
  {
    $events = $this->eventService->getAllEvents();


    $html = $this->view->render('events.html.twig', [
      'events' => $events->toArray(),
    ]);

    return $this->responseFactory->createHtmlResponse(200, $html);
  }

  public function show(ServerRequestInterface $request, int $id): ResponseInterface
  {
    $event = $this->eventService->getEventById($id);

    $html = $this->view->render('event.html.twig', [
      'event' => $event,
    ]);
    
    return $this->responseFactory->createHtmlResponse(200, $html);
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

    return $this->responseFactory->createHtmlResponse(200, '');
  }
}