<?php
namespace Framework\Auth\Middleware;

use Framework\Auth\Exception\InsufficientAuthenticationException;
use Framework\Auth\Exception\UnauthenticatedException;
use Framework\Auth\Model\Entity\Role;
use Framework\Auth\Model\Entity\User;
use Framework\Auth\Model\Service\AuthService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Throws 401 exception if user is not admin or higher
 */
class AdminAuthMiddleware implements MiddlewareInterface
{
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    $user = $this->getUserFromRequest($request);

    if ($user === null) {
      throw new UnauthenticatedException();
    }

    if (!($user->getRoleId() >= Role::ADMIN)) {
      throw new InsufficientAuthenticationException();
    }

    return $handler->handle($request);
  }

  private function getUserFromRequest(ServerRequestInterface $request): ?User
  {
    return $request->getAttribute('user');
  }
}