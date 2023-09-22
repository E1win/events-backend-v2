<?php
namespace Framework\Message\Contract;

use Psr\Http\Message\ResponseInterface;

interface JsonResponseFactoryInterface
{
  public function createJsonResponse(array $data = [], int $status = 200): ResponseInterface;
}