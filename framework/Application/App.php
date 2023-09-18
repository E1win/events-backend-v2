<?php
namespace Framework\Application;

use Framework\Container\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

// Probably have container as a static instance

class App
{
  public function __construct(Container $container)
  {
    
  }

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    // . . .
  }
}