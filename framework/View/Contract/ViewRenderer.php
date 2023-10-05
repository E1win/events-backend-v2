<?php
namespace Framework\View\Contract;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ViewRenderer
{
  public function load(string $url, array $context = [], ?ServerRequestInterface $request = null): ResponseInterface;
}