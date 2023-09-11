<?php
namespace Framework\Routing;

use Framework\Routing\Contract\DispatcherInterface;
use Framework\Routing\Contract\RouteInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Dispatcher implements DispatcherInterface, RequestHandlerInterface
{

  public function dispatch(RouteInterface $route, ServerRequestInterface $request): ResponseInterface
  {
    // add all from route middleware to stack

    // add route to end of middleware stack

    return $this->handle($request);
  } 

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    // $middleware = (take item off of middleware and remove it from stack)
    // $middleware->process($request, $this);
  }
}