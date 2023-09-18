<?php
namespace Framework\Routing\Contract;

use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
  public function match(ServerRequestInterface $request): RouteInterface;
}