<?php
namespace Framework\Auth\Exception;

use Exception;

class InsufficientAuthenticationException extends Exception
{
  public function __construct(string $message = "Insufficient authentication or role for current route.", int $code = 401, \Throwable|null $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}