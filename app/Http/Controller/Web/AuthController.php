<?php
namespace App\Http\Controller\Web;

use Framework\Auth\Model\Service\AuthService;
use Framework\Controller\Controller;
use Framework\Message\Contract\HtmlResponseFactoryInterface;
use Framework\Message\Contract\RedirectResponseFactoryInterface;
use Framework\Message\ServerRequest;
use Framework\View\Contract\ViewRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Twig\Environment;

class AuthController extends Controller
{
  public function __construct(
    private AuthService $authService,
    private ViewRenderer $view,
    private RedirectResponseFactoryInterface $redirectResponseFactory,
  ) {}

  public function login(ServerRequestInterface $request): ResponseInterface
  {
    return $this->view->load('login.html');
  }
}