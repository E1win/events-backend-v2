<?php

/**
 * Set aliases used for interfaces in this file.
 */

return [
  Framework\Middleware\Contract\MiddlewareStackInterface::class => Framework\Middleware\MiddlewareStack::class,
  Psr\Http\Message\ResponseFactoryInterface::class => Framework\Message\Factory::class,
  Framework\Message\Contract\JsonResponseFactoryInterface::class => Framework\Message\Factory::class,
  Framework\Message\Contract\HtmlResponseFactoryInterface::class => Framework\Message\Factory::class,
];