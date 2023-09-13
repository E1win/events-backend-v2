<?php
namespace Framework\Middleware;

use Psr\Http\Server\MiddlewareInterface;

class MiddlewareStack
{
  /**
   * Array containing all middleware in stack
   * 
   * @var MiddlewareInterface[]
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

  public function append(MiddlewareInterface $middleware): self
  {
    $this->stack[] = $middleware;

    return $this;
  }
}