<?php
namespace Framework\Auth\Middleware;

use Framework\Message\Contract\RedirectResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * Redirects to /login screen,
 * if 401 exception is thrown
 */
class LoginRedirectMiddleware implements MiddlewareInterface
{
  public function __construct(
    private RedirectResponseFactoryInterface $redirectResponseFactory,
  ) {}

  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    try {
      return $handler->handle($request);
    } catch (\Throwable $th) {
      if ($th->getCode() === 401) {
        // redirect to /login.
        // TODO: maybe add error or something so they can see it?
        return $this->redirectResponseFactory->createRedirectResponse('/login');
      }

      throw $th;
    }
  }
}