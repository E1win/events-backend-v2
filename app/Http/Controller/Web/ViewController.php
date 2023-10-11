<?php
namespace App\Http\Controller\Web;

use Framework\Controller\Controller;
use Framework\View\Contract\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ViewController extends Controller
{
  public function __construct(
    private ViewRenderer $view,
  ) {}

  public function home(ServerRequestInterface $request): ResponseInterface
  {
    return $this->view->load('home.html', $request, []);
  }
}