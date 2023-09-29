<?php

/**
 * Set aliases used for interfaces in this file.
 */

use Framework\FileSystem\Contract\FileSystemManager as ContractFileSystemManager;
use Framework\FileSystem\FileSystemManager;

return [
  Framework\Middleware\Contract\MiddlewareStackInterface::class => Framework\Middleware\MiddlewareStack::class,
  Psr\Http\Message\ResponseFactoryInterface::class => Framework\Message\Factory::class,
  Framework\Message\Contract\JsonResponseFactoryInterface::class => Framework\Message\Factory::class,
  Framework\Message\Contract\HtmlResponseFactoryInterface::class => Framework\Message\Factory::class,
  ContractFileSystemManager::class => FileSystemManager::class,
];