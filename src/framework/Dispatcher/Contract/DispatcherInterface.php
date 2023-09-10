<?php

use Framework\Routing\Contract\RouteInterface;

use Psr\Http\Message\ResponseInterface;

interface DispatcherInterface
{
  /**
   * Dispatch a request of a given route.
   */
  public function dispatch(RouteInterface $route): ResponseInterface;
}