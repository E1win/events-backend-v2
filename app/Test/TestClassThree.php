<?php
namespace App\Test;

class TestClassThree
{
  public function __construct(public TestClassOne $myClass)
  {
  }
}
