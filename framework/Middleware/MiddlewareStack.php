<?php
namespace Framework\Middleware;

use Psr\Http\Server\MiddlewareInterface;

class MiddlewareStack implements MiddlewareStackInterface
{
  /**
   * Array containing all middleware in stack
   */
  protected array $stack = [];

  public function __construct(MiddlewareInterface ...$middlewares)
  {
    $this->stack = (array) $middlewares ?? [];
  }

  public function getStack(): array
  {
    return $this->stack;
  }

  public function shift(): MiddlewareInterface
  {
    return array_shift($this->stack);
  }

  public function prepend(MiddlewareInterface $middleware): self
  {
    array_unshift($this->stack, $middleware);

    return $this;
  }

  public function prependArray(array $middlewares): self
  {
    array_unshift($this->stack, $middlewares);

    return $this;
  }

  public function append(MiddlewareInterface $middleware): self
  {
    $this->stack[] = $middleware;

    return $this;
  }

  public function appendArray(array $middlewares): self
  {
    $this->stack[] += $middlewares;

    return $this;
  }
}