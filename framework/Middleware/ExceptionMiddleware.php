<?php
namespace Framework\Middleware;

use Framework\Message\Contract\JsonResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExceptionMiddleware implements MiddlewareInterface
{
  public function __construct(
    private JsonResponseFactoryInterface $jsonResponseFactory,
  ) { }

  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    return $handler->handle($request);
    try {
    } catch (\Throwable $e) {
      throw new $e;
      // Return exception as response
      // formatting here
    }
  }
}