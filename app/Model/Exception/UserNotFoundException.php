<?php
namespace App\Model\Exception;

use Exception;

class UserNotFoundException extends Exception
{
  public function __construct(string $message = "No user found with provided email.", int $code = 401, \Throwable|null $previous = null)
  {
    parent::__construct($message, $code, $previous);
  }
}