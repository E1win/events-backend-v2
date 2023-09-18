<?php
namespace Framework\Routing;

use Framework\Application\App;
use Framework\Message\Response;
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
  protected string $method;

  /**
   * Route action array
   */
  private $action;

  private array $tokens;

  public function __construct($method, string $pattern, $action)
  {
    $this->pattern = $pattern;
    // TODO: Check if method(s) are valid
    $this->method = $method;
    // TODO: Check if action is valid
    $this->action = $action;
  }

  public function getMethod(): string
  {
    return $this->method;
  }

  public function getPattern(): string
  {
    return $this->pattern;
  }

  public function addToken(string $name, mixed $value)
  {
    $this->tokens[$name] = $value;
  }

  public function getTokens(): array
  {
    return $this->tokens;
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

    return new Response();
  }

  public function getAction(): callable
  {
    return $this->action;
  }
}