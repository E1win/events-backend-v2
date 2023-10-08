<?php
namespace Framework\Auth\Exception;

use Exception;

class InvalidPasswordException extends Exception
{
  public function __construct(string $message = "Given password is invalid.", int $code = 401, \Throwable|null $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}