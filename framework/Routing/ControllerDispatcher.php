<?php
namespace Framework\Routing;

use Framework\Routing\Contract\DispatcherInterface;
use Framework\Routing\Contract\RouteInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;

class ControllerDispatcher
{
  /**
   * The container instance
   */

  public function __construct(private ContainerInterface $container)
  {
  }

  public function dispatch(RouteInterface $route, ServerRequestInterface $request): ResponseInterface
  {
    $action = $route->getAction();

    $controllerName = $action[0];
    $method = $action[1];

    $controller = $this->container->get($controllerName);


    return $controller->callAction($method, [$request, ...array_values($route->getTokens())]);
  }
}