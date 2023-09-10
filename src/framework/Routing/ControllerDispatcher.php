<?php
namespace Framework\Routing;

use Framework\Routing\Contract\DispatcherInterface;
use Framework\Routing\Contract\RouteInterface;
use Psr\Http\Message\ResponseInterface;

class ControllerDispatcher implements DispatcherInterface
{
  public function dispatch(RouteInterface $route): ResponseInterface
  {
    // . . .
  }
}