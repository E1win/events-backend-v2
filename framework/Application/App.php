<?php
namespace Framework\Application;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

// Probably have container as a static instance

class App
{
  // $router

  // $dispatcher

  public function handle(ServerRequestInterface $request): ResponseInterface
  {
    // . . .
  }
}