<?php
namespace Framework\Container\Exception;

use Psr\Container\ContainerExceptionInterface;

class ContainerCantResolveClassParametersException extends \Exception implements ContainerExceptionInterface
{
  public function __construct(string $className)
  {
    parent::__construct("Container failed to resolve parameters of class: '{$className}'");
  }
}