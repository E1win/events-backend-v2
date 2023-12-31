<?php
namespace Framework\Routing\Contract;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

interface RouterInterface
{
  /**
   * Match request to class routes
   */
  public function match(ServerRequestInterface $request): ?RouteInterface;

  public function group(string $prefix, callable $callback): RouterInterface;
  public function groupRouter(string $prefix, RouterInterface $router): RouterInterface;

  // HTTP-methods
  public function get(string $pattern, mixed $callback): void;
  public function post(string $pattern, mixed $callback): void;
  public function delete(string $pattern, mixed $callback): void;
  public function put(string $pattern, mixed $callback): void;

  // Add middleware to route
  public function addMiddleware(string $middleware);
  public function addMiddlewares(array $middlewares);

  // Add prefix to router
  public function addPrefix(string $prefix): self;
  public function getPrefix(): string;

  /** @return RouteInterface[] */
  public function getRoutes(): array;
}