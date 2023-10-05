<?php

/**
 * Set aliases used for interfaces in this file.
 */

use Framework\FileSystem\Contract\FileSystemManager as ContractFileSystemManager;
use Framework\FileSystem\FileSystemManager;
use Framework\Message\Contract\HtmlResponseFactoryInterface;
use Framework\Message\Contract\JsonResponseFactoryInterface;
use Framework\Message\Contract\RedirectResponseFactoryInterface;
use Framework\Message\Factory;
use Framework\View\Contract\ViewRenderer as ContractViewRenderer;
use Framework\View\ViewRenderer;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;

return [
  Framework\Middleware\Contract\MiddlewareStackInterface::class => Framework\Middleware\MiddlewareStack::class,
  ResponseFactoryInterface::class => Factory::class,
  JsonResponseFactoryInterface::class => Factory::class,
  HtmlResponseFactoryInterface::class => Factory::class,
  RedirectResponseFactoryInterface::class => Factory::class,
  StreamFactoryInterface::class => Factory::class,
  ContractFileSystemManager::class => FileSystemManager::class,
  ContractViewRenderer::class => ViewRenderer::class,
];