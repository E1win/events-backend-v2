<?php
namespace Framework\Middleware;

use Framework\Application\App;
use Framework\Middleware\Contract\MiddlewareStackInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareStack implements MiddlewareStackInterface
{
  /**
   * Array containing all middleware in stack
   */
  protected array $stack = [];

  public function getStack(): array
  {
    return $this->stack;
  }

  public function shift(): MiddlewareInterface
  {
    $middleware = array_shift($this->stack);

    if ($middleware instanceof MiddlewareInterface)
      return $middleware;

    return App::getContainer()->get($middleware);
  }

  public function prepend(MiddlewareInterface|string $middleware): self
  {
    array_unshift($this->stack, $middleware);

    return $this;
  }

  public function prependArray(array $middlewares): self
  {
    array_unshift($this->stack, $middlewares);

    return $this;
  }

  public function append(MiddlewareInterface|string $middleware): self
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