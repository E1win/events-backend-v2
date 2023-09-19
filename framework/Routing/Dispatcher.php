<?php
namespace Framework\Routing;

use Framework\Middleware\Contract\MiddlewareStackInterface;
use Framework\Routing\Contract\DispatcherInterface;
use Framework\Routing\Contract\RouteInterface;
use Framework\Routing\Contract\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Dispatcher implements DispatcherInterface, RequestHandlerInterface
{
  protected RouterInterface $router;
  protected MiddlewareStackInterface $middlewareStack;

  public function __construct(RouterInterface $router, MiddlewareStackInterface $middlewareStack)
  {
    $this->router = $router;
    $this->middlewareStack = $middlewareStack;
  }

  public function dispatch(ServerRequestInterface $request): ResponseInterface
  {
    $route = $this->router->match($request);
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