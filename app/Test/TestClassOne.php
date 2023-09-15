<?php
namespace App\Test;

class TestClassOne implements TestInterface
{
  public function __construct(public int $myNumber)
  {
  }

  public function testMethod(): void
  {
    echo '<br>In Test Method<br>';
  }
}