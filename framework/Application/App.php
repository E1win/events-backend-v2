<?php
namespace Framework\Application;

use Framework\Container\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
  private static ContainerInterface $container;

  public function __construct(Container $container)
  {
    $this->container = $container;

    // add middlewares, etc.
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    // dispatcher
    // routes
  }

  public function getContainer(): ContainerInterface
  {
    return $this->container;
  }
}