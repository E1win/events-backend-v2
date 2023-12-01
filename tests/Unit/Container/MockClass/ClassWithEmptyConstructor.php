<?php
namespace Tests\Unit\Container\MockClass;


class ClassWithEmptyConstructor
{
  private int $number = -1;

  public function __construct()
  {
    $this->number = 10;
  }

  public function getNumber(): int
  {
    return $this->number;
  }
}