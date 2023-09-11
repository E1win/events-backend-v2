<?php
namespace Framework\Routing\Contract;

use Framework\Routing\Contract\RouteInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface DispatcherInterface
{
  /**
   * Dispatch a request of a given route.
   */
  public function dispatch(RouteInterface $route, ServerRequestInterface $request): ResponseInterface;
}