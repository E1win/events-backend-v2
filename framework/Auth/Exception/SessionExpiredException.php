<?php
namespace Framework\Auth\Exception;

use Exception;

class SessionExpiredException extends Exception
{
  public function __construct(string $message = "Your session has expired.", int $code = 401, \Throwable|null $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}