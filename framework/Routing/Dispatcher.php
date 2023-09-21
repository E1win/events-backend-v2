<?php
namespace Framework\Routing;

use Framework\Message\Response;
use Framework\Middleware\Contract\MiddlewareStackInterface;
use Framework\Middleware\MiddlewareStack;
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

  public static function create(RouterInterface $router)
  {
    return new Dispatcher($router, new MiddlewareStack());
  }

  public function __construct(RouterInterface $router, MiddlewareStackInterface $middlewareStack)
  {
    $this->router = $router;
    $this->middlewareStack = $middlewareStack;
  }

  public function dispatch(ServerRequestInterface $request): ResponseInterface
  {
    $route = $this->router->match($request);

    if ($route == null) {
      return new Response(404);
    }
    
    $this->addRouteMiddlewaresToStack($route);

    return $this->handle($request);
  } 

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    $middleware = $this->middlewareStack->shift();
    return $middleware->process($request, $this);
  }

  private function addRouteMiddlewaresToStack(RouteInterface $route)
  {
    $routeMiddlewareStack = $route->getMiddlewareStack();

    $this->middlewareStack->appendArray(
      $routeMiddlewareStack->getStack()
    );

    // add route to end of middleware stack
    $this->middlewareStack->append($route);
  }
}