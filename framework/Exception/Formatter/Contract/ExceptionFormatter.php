<?php
namespace Framework\Exception\Formatter\Contract;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

interface ExceptionFormatter
{
  public function isValid(Throwable $error, ServerRequestInterface $request): bool;

  public function handle(Throwable $error, ServerRequestInterface $request): ResponseInterface;
}