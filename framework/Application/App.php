<?php
namespace Framework\Application;

use Framework\Container\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
  public static ContainerInterface $container;

  public function __construct(Container $container)
  {
    App::$container = $container;

    // add middlewares, etc.
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    // dispatcher
    // routes
  }

  public static function getContainer(): ContainerInterface
  {
    return App::$container;
  }
}