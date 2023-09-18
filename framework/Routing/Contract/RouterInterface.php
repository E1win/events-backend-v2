<?php
namespace Framework\Routing\Contract;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

interface RouterInterface
{
  /**
   * Match request to class routes
   */
  public function match(ServerRequestInterface $request): RouteInterface;

  public function group(string $prefix, RouterInterface $router);

  // HTTP-methods
  public function get(string $pattern, callable $callback): void;
  public function post(string $pattern, callable $callback): void;
  public function delete(string $pattern, callable $callback): void;
  public function put(string $pattern, callable $callback): void;

  // Add route for given HTTP method
  public function method(string $method, string $pattern, callable $callback): void;

  // Add middleware to route
  public function addMiddleware(MiddlewareInterface $middleware);
  public function addMiddlewares(array $middlewares);

  // Add prefix to router
  public function addPrefix(string $prefix): self;
}