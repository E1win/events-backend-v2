<?php

/**
 * Array of global middleware
 */

use Framework\Auth\Middleware\UserMiddleware;
use Framework\Exception\ExceptionMiddleware;

return [
  ExceptionMiddleware::class,
  UserMiddleware::class,
];