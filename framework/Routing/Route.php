<?php
namespace Framework\Routing;

use Framework\Application\App;
use Framework\Routing\Contract\RouteInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Route implements RouteInterface
{
  /**
   * URI pattern the route responds to
   */
  protected string $pattern;

  /**
   * HTTP methods the route responds to (GET, POST, etc.)
   */
  protected array $methods;

  /**
   * Route action array
   */
  protected array $action;

  /**
   * Controller instance
   */
  protected mixed $controller;

  public function __construct($methods, string $pattern, $action)
  {
    $this->pattern = $pattern;
    // TODO: Check if method(s) are valid
    $this->methods = (array) $methods;
    // TODO: Check if action is valid
    $this->action = $action;
  }

  /**
   * Run the route action and return the response
   */
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    return $this->runController($request);
  }

  /**
   * Run the route controller action and return the response
   */
  protected function runController(ServerRequestInterface $request): ResponseInterface
  {
    $container = App::getContainer();
    // use ControllerDispatcher to dispatch route
    // new ControllerDispatcher();
    // controllerDispatcher->dispatch($this, $request)
  }

  public function getAction(): array
  {
    return $this->action;
  }
}