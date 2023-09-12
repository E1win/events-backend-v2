<?php
namespace Framework\Model\Mapper\Contract;

interface MapperFactoryInterface
{
  public function create(string $className);
}