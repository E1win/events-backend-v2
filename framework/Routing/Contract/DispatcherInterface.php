<?php
namespace Framework\Routing\Contract;

use Framework\Routing\Contract\RouteInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface DispatcherInterface
{
  /**
   * Dispatch a request
   */
  public function dispatch(ServerRequestInterface $request): ResponseInterface;
}