<?php

/**
 * Array of global middleware
 */

use Framework\Auth\Middleware\UserInRequestMiddleware;
use Framework\Exception\ExceptionMiddleware;
use Framework\Middleware\CorsMiddleware;

return [
  ExceptionMiddleware::class,
  CorsMiddleware::class
];