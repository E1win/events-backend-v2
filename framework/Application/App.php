<?php
namespace Framework\Application;

use Framework\Container\Container;
use Framework\Message\Contract\SendableResponseInterface;
use Framework\Routing\Contract\DispatcherInterface;
use Framework\Routing\Contract\RouteGathererInterface;
use Framework\Routing\Contract\RouterInterface;
use Framework\Routing\Dispatcher;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class App
{
  public static ContainerInterface $container;

  private RouteGathererInterface $routeGatherer;

  private RouterInterface $router;

  private DispatcherInterface $dispatcher;

  public function __construct(Container $container, RouteGathererInterface $routeGatherer)
  {
    App::$container = $container;

    $this->routeGatherer = $routeGatherer;

    // add middlewares, etc.
  }

  public function run(ServerRequestInterface $request, ?RouterInterface $router = null)
  {
    $this->router = $this->loadRoutes($router);
    $this->loadDispatcher($this->router);
    $response = $this->dispatcher->dispatch($request);
    $this->sendResponse($response);
  }

  private function loadRoutes(?RouterInterface $router = null): RouterInterface
  {
    if ($router == null) {
      return $this->routeGatherer->load();
    }

    return $router;
  }

  private function loadDispatcher(RouterInterface $router)
  {
    $this->dispatcher = Dispatcher::create($router);
  }

  private function sendResponse(SendableResponseInterface $response)
  {
    $response->send();
  }

  public static function getContainer(): ContainerInterface
  {
    if (App::$container == null) {
      App::$container = Container::createWithDefaultConfiguration();
    }
    
    return App::$container;
  }
}