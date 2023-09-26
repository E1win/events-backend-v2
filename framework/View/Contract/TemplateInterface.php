<?php
namespace Framework\View\Contract;

use Psr\Http\Message\ResponseInterface;
use Stringable;

interface TemplateInterface extends Stringable
{
  public function render(array $parameters = []): string;
}