<?php
namespace App\Test;

class TestClassThree
{
  public function __construct(public TestClassOne $myClass)
  {
  }

  public function testMethod()
  {
    echo 'Test Method in TestClassThree';
  }
}
