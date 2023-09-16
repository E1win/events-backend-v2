<?php
namespace Tests\Unit\Container\MockClass;


class ClassWithDependency
{
  public function __construct(public ClassWithPrimitiveParameter $dependency)
  {
  }
}