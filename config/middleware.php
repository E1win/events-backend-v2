<?php

/**
 * Array of global middleware
 */

use Framework\Auth\Middleware\UserInRequestMiddleware;
use Framework\Exception\ExceptionMiddleware;

return [
  ExceptionMiddleware::class,
  UserInRequestMiddleware::class,
];