<?php
namespace Framework\View\Contract;

use Psr\Http\Message\ResponseInterface;

interface ViewRendererInterface
{
  public function render(string $name, array $parameters = []): ResponseInterface;
}