<?php
namespace Framework\Message\Contract;

use Psr\Http\Message\ResponseInterface;

interface RedirectResponseFactoryInterface
{
  public function createRedirectResponse(string $url, int $statusCode = 302, array $headers = []): ResponseInterface;
}