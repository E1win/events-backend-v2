<?php
namespace App\Test;

class TestClassTwo
{
  public function __construct(
    public TestClassOne $myClass, 
    public int $myNumber, 
    public ?string $myNullableString = null
  ) {
    
  }
}