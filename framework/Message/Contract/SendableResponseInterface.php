<?php
namespace Framework\Message\Contract;

use Psr\Http\Message\ResponseInterface;

interface SendableResponseInterface extends ResponseInterface
{
  public function send(): void;
}