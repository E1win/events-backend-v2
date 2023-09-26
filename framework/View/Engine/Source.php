<?php
namespace Framework\View\Engine;

use Framework\View\Engine\Contract\SourceInterface;

class Source implements SourceInterface
{
  private $code;
  private $path;

  public function __construct(string $code, string $path = '')
  {
    $this->code = $code;
    $this->path = $path;
  }

  public function getCode(): string
  {
    return $this->code;
  }

  public function getPath(): string
  {
    return $this->path;
  }
}