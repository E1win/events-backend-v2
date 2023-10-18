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
class UserInRequestMiddleware implements MiddlewareInterface
{
  public function __construct(
    private UserService $userService,
  ) { }

  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    if ($this->userService->sessionTokenInRequest($request)) {
      $token = $this->userService->getSessionTokenFromRequest($request);

      $user = $this->userService->getUserByToken($token);

      return $handler->handle($request->withAttribute('user', $user));
    }

    return $handler->handle($request);
  }
}