<?php
namespace App\Http\Controller\Web;

use Framework\Controller\Controller;
use Framework\View\Contract\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UserController extends Controller
{
  public function __construct(
    private ViewRenderer $view,
  ) {}

  public function index(ServerRequestInterface $request): ResponseInterface
  {
    return $this->view->load('users.html', $request);
  }
}