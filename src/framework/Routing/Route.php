<?php
namespace Framework\Routing;

use Framework\Routing\Contract\RouteInterface;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class Route implements RouteInterface
{
  /**
   * URI pattern the route responds to
   */
  protected string $uri;

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

  public function __construct($methods, string $uri, $action)
  {
    $this->uri = $uri;
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
    try {
      return $this->runController($request);
    } catch (\Exception $e) {
      // Return exception response
    }
  }

  /**
   * Run the route controller action and return the response
   */
  protected function runController(ServerRequestInterface $request): ResponseInterface
  {
    // use ControllerDispatcher to dispatch route
    // controllerDispatcher->dispatch($this, $request)
  }
}