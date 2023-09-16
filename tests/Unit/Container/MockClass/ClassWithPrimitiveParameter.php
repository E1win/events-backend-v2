<?php
namespace Tests\Unit\Container\MockClass;


class ClassWithPrimitiveParameter implements MockInterface
{
  public function __construct(public int $number)
  {
  }

  public function getNumber(): int
  {
    return $this->number;
  }
}