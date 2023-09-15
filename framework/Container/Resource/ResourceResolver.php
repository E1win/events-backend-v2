<?php
namespace Framework\Container\Resource;

use Framework\Container\Contract\ContainerResourceInterface;

class ResourceResolver
{
  public function resolve(ContainerResourceInterface $resource)
  {
    $className = $resource->getName();

    

    return $resource;
  }
}