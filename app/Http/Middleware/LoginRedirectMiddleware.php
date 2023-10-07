<?php
namespace App\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

// middleware will probably be added on web endpoints

/**
 * Redirects to /login screen,
 * if 401 exception is thrown
 */
class LoginRedirectMiddleware implements MiddlewareInterface
{
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    try {
      return $handler->handle($request);
    } catch (\Throwable $th) {
      if ($th->getCode() === 401) {
        // redirect to /login
      }
    }
  }
}