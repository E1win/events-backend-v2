<?php
namespace Tests\Unit\Container\MockClass;


class ClassWithInterfaceDependency
{
  public function __construct(public MockInterface $dependency)
  {
  }
}