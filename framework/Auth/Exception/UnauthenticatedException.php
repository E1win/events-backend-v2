<?php
namespace Framework\Auth\Exception;

use Exception;

class UnauthenticatedException extends Exception
{
  public function __construct(string $message = "Invalid or missing authentication for current route.", int $code = 401, \Throwable|null $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}