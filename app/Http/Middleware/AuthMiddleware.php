<?php
namespace App\Http\Middleware;

use App\Exception\UnauthenticatedException;
use App\Model\Entity\User;
use App\Model\Service\Auth\AuthService;
use App\Model\Service\Auth\SessionService;
use Dotenv\Exception\ValidationException;
use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
  public function __construct(
    private AuthService $authService,
    private SessionService $sessionService,
  ) { }

  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    if ($this->sessionService->sessionExistsInRequest($request)) {
      $sessionUuid = $this->sessionService->getSessionUuidFromRequest($request);

      $session = $this->sessionService->getSessionByUuid($sessionUuid);

      $user = $this->authService->loginWithSession($session);

      // if session does not exist, or invalid:
      // maybe redirect to /login probably
      return $handler->handle($request->withAttribute('user', $user));
    }

    throw new UnauthenticatedException();
  }

  public function requestToApiRoute(ServerRequestInterface $request): bool
  {
    var_dump($request);

    return false;
  }
}