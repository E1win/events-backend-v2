<?php
namespace App\Test;

class TestClassThree
{
  public function __construct(public TestInterface $myClass)
  {
  }

  public function testMethod()
  {
    echo 'Test Method in TestClassThree';
  }
}
