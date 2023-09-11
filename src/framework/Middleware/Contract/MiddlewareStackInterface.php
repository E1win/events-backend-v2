<?php
namespace Framework\Middleware;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareStackInterface
{
  public function shift(): MiddlewareInterface;

  public function prepend(MiddlewareInterface $middleware): self;

  public function append(MiddlewareInterface $middleware): self;
}