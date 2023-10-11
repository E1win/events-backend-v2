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

  public function showLogin(ServerRequestInterface $request): ResponseInterface
  {
    return $this->view->load('login.html');
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
    $user = $request->getAttribute('user');

    $this->authService->logout($user);

    return $this->redirectResponseFactory->createRedirectResponse("/login");
  }

  public function authRoute(ServerRequestInterface $request): ResponseInterface
  {
    /**
     * TODO: Maybe just a getUser method on the request?
     * returns null if no user is there
     */
    $user = $request->getAttribute('user');

    return $this->view->load('auth.html', $request, [
      'user' => $user,
    ]);
  }
}