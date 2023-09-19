<?php
namespace Framework\Middleware;

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
  public function prepend(MiddlewareInterface $middleware): self;

  /**
   * Add to beginning of stack.
   * @param MiddlewareInterface[] $middlewares;
   */
  public function prependArray(array $middlewares): self;

  /**
   * Add to end of stack.
   */
  public function append(MiddlewareInterface $middleware): self;

  /**
   * Add to end of stack.
   * @param MiddlewareInterface[] $middlewares;
   */
  public function appendArray(array $middlewares): self;
}