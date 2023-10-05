<?php
namespace Framework\Exception\Formatter;

use Framework\Exception\Formatter\Contract\ExceptionFormatter;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Psr\Http\Message\ServerRequestInterface;

abstract class AbstractFormatter implements ExceptionFormatter
{
  public function isValid(Throwable $error, ServerRequestInterface $request): bool
  {
    return true;
  }

  public function handle(Throwable $error, ServerRequestInterface $request): ResponseInterface
  {
    
  }
}