<?php
namespace Framework\Routing\Contract;

use Psr\Http\Message\ResponseInterface;

interface RouteInterface
{
  public function run(): ResponseInterface;
}