<?php
namespace Framework\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * TODO: Probably don't use wildcare * on Allow-Origin
 */
class CorsMiddleware implements MiddlewareInterface
{
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    return $handler->handle($request)
      ->withHeader('Access-Control-Allow-Origin', 'http://localhost')
      ->withHeader('Access-Control-Allow-Credentials', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
      ->withHeader('Access-Control-Allow-Headers', 'true');
  }
}