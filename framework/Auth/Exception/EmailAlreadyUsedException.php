<?php
namespace Framework\Auth\Exception;

use Exception;

class EmailAlreadyUsedException extends Exception
{
  public function __construct(string $message = "User with given email already exists.", int $code = 409, \Throwable|null $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}