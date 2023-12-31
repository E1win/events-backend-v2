<?php
namespace Framework\Middleware\Contract;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareStackInterface
{
  public function getStack(): array;

  /**
   * Remove from beginning of stack
   * and return removed item.
   */
  public function shift(): MiddlewareInterface;

  /**
   * Add to beginning of stack.
   */
  public function prepend(MiddlewareInterface|string $middleware): self;

  /**
   * Add to beginning of stack.
   * @param MiddlewareInterface[]|string[] $middlewares;
   */
  public function prependArray(array $middlewares): self;

  /**
   * Add to end of stack.
   */
  public function append(MiddlewareInterface|string $middleware): self;

  /**
   * Add to end of stack.
   * @param MiddlewareInterface[]|string[] $middlewares;
   */
  public function appendArray(array $middlewares): self;
}