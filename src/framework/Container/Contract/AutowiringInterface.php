<?php
namespace Framework\Container\Contract;

interface AutowiringInterface
{
  public function autowire(string $name);
}