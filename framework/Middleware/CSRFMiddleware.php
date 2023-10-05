<?php
namespace Framework\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CSRFMiddleware implements MiddlewareInterface
{
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    if ($this->tokensMatch($request)) {
      return $this->addCookiesToResponse($request, $handler);
    }
    return $handler->handle($request);
  }

  private function tokensMatch(ServerRequestInterface $request)
  {
    // check if tokens match
  }

  private function addCookiesToResponse(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    $config = config('session.php');
    // . . .
  }
}