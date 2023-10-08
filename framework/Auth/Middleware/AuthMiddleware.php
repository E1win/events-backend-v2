<?php
namespace Framework\Auth\Middleware;

use Framework\Auth\Model\Service\UserService;
use Framework\Auth\Exception\UnauthenticatedException;
use Framework\Auth\Model\Service\AuthService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AuthMiddleware implements MiddlewareInterface
{
  public function __construct(
    private AuthService $authService,
  ) { }

  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    if ($this->sessionExistsInRequest($request)) {
      $sessionUuid = $this->getSessionUuidFromRequest($request);

      $user = $this->authService->loginWithSessionUuid($sessionUuid);

      // if session does not exist, or invalid:
      // maybe redirect to /login probably
      return $handler->handle($request->withAttribute('user', $user));
    }

    throw new UnauthenticatedException();
  }

  private function sessionExistsInRequest(ServerRequestInterface $request): bool
  {
    $cookies = $request->getCookieParams();

    return isset($cookies[UserService::SESSION_COOKIE_NAME]);
  }

  private function getSessionUuidFromRequest(ServerRequestInterface $request): string
  {
    return $request->getCookieParams()[UserService::SESSION_COOKIE_NAME];
  }


  public function requestToApiRoute(ServerRequestInterface $request): bool
  {
    var_dump($request);

    return false;
  }
}