<?php
namespace Framework\View\Engine\Contract;

/**
 * Holds information about non-compiled HTML file.
 */
interface SourceInterface
{
  public function getCode(): string;

  public function getPath(): string;
}