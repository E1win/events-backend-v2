<?php
namespace Framework\Routing;

use Framework\Routing\Contract\DispatcherInterface;
use Framework\Routing\Contract\RouteInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Container\ContainerInterface;

class ControllerDispatcher implements DispatcherInterface
{
  /**
   * The container instance
   */
  protected $container;

  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  public function dispatch(RouteInterface $route): ResponseInterface
  {
    // . . .
  }
}