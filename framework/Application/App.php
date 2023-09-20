<?php
namespace Framework\Application;

use Framework\Container\Container;
use Framework\Routing\Contract\DispatcherInterface;
use Framework\Routing\Contract\RouterInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
  public static ContainerInterface $container;

  private RouterInterface $router;

  private DispatcherInterface $dispatcher;

  public function __construct(Container $container)
  {
    App::$container = $container;

    // add middlewares, etc.
  }

  public function run(?RouterInterface $router = null)
  {
    if ($router == null) {
      // $this->loadRoutes();
    }
    // loadRoutes().
    // . . .
  }

  public static function getContainer(): ContainerInterface
  {
    if (App::$container == null) {
      App::$container = Container::createWithDefaultConfiguration();
    }
    
    return App::$container;
  }

}