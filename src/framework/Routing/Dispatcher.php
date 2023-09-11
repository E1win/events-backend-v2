<?php
namespace Framework\Routing;

use Framework\Middleware\MiddlewareStackInterface;
use Framework\Routing\Contract\DispatcherInterface;
use Framework\Routing\Contract\RouteInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Dispatcher implements DispatcherInterface, RequestHandlerInterface
{
  protected MiddlewareStackInterface $middlewareStack;

  public function __construct(MiddlewareStackInterface $middlewareStack)
  {
    $this->middlewareStack = $middlewareStack;
  }

  public function dispatch(RouteInterface $route, ServerRequestInterface $request): ResponseInterface
  {
    // add all middleware from route middleware to stack

    // add route to end of middleware stack
    $this->middlewareStack->append($route);

    return $this->handle($request);
  } 

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $middleware = $this->middlewareStack->shift();
    return $middleware->process($request, $this);
  }
}