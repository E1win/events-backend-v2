<?php
namespace Framework\Routing\Contract;

use Psr\Http\Server\MiddlewareInterface;

interface RouteInterface extends MiddlewareInterface
{
  public function getMethod(): string;

  public function getPattern(): string;

  public function addToken(string $name, mixed $value);

  public function getTokens(): array;
}