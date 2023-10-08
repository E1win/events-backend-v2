<?php
namespace Framework\Auth\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * TODO: This CSRF middleware,
 * need to learn more about it, but probably like this:
 * 
 * When on a page with a form, create CSRF token server-side and put it somewhere
 * in the page (in a form or something), then store it in the database (probably with user)
 * When a POST request is send, check if token sent matches with token in database
 * If it doesn't, it probably means request is compromised
 */

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