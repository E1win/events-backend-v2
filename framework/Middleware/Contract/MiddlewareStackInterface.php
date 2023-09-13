<?php
namespace Framework\Middleware;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareStackInterface
{
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
   * Add to end of stack.
   */
  public function append(MiddlewareInterface $middleware): self;
}