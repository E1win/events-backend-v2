<?php
namespace Framework\Auth\Middleware;

use Framework\Auth\Exception\UnauthenticatedException;
use Framework\Auth\Model\Entity\User;
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
    $user = $this->getUserFromRequest($request);

    if ($user === null) {
      throw new UnauthenticatedException();
    }

    $this->authService->loginWithUser($user);

    return $handler->handle($request);
  }

  private function getUserFromRequest(ServerRequestInterface $request): ?User
  {
    return $request->getAttribute('user');
  }

  public function requestToApiRoute(ServerRequestInterface $request): bool
  {
    var_dump($request);

    return false;
  }
}