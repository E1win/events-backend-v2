<?php
namespace Framework\Auth\Middleware;

use Framework\Auth\Model\Service\UserService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Adds user to request attributes,
 * if session uuid is in cookies.
 */
class UserMiddleware implements MiddlewareInterface
{
  public function __construct(
    private UserService $userService,
  ) { }

  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    if ($this->sessionExistsInRequest($request)) {
      $sessionUuid = $this->getSessionUuidFromRequest($request);

      $user = $this->userService->getUserBySessionUuid($sessionUuid);

      return $handler->handle($request->withAttribute('user', $user));
    }

    return $handler->handle($request);
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
}