<?php
namespace App\Http\Controller\Web;

use App\Model\Service\Auth\AuthService;
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

  public function showLogin(ServerRequestInterface $request): ResponseInterface
  {
    return $this->view->load('login.html.twig');
  }

  public function login(ServerRequestInterface $request): ResponseInterface
  {
    $body = $request->getParsedBody();

    // var_dump($body);

    $email = $body['email'];
    $password = $body['password'];

    $user = $this->authService->loginWithEmailAndPassword($email, $password);

    return $this->redirectResponseFactory->createRedirectResponse("/auth");
  }

  public function logout(ServerRequestInterface $request): ResponseInterface
  {
    // $this->authService->logout(/* */);

    return $this->redirectResponseFactory->createRedirectResponse("/login");
  }

  public function authRoute(ServerRequestInterface $request): ResponseInterface
  {
    $user = $request->getAttribute('user');

    return $this->view->load('auth.html.twig', [
      'user' => $user,
    ]);
  }
}