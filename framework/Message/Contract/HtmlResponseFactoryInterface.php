<?php
namespace Framework\Message\Contract;

use Psr\Http\Message\ResponseInterface;

interface HtmlResponseFactoryInterface
{
  public function createHtmlResponse(int $statusCode, $html): ResponseInterface;
}