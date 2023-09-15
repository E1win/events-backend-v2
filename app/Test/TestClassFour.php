<?php
namespace App\Test;

class TestClassFour
{
  public function __construct(public TestClassThree $myClassOne, public TestClassTwo $myClassTwo)
  {
  }
}
