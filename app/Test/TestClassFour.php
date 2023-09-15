<?php
namespace App\Test;

class TestClassFour
{
  public function __construct(public TestClassThree $myClassThree, public TestInterface $myClassInterface)
  {
  }
}
