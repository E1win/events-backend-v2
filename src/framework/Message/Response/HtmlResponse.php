<?php
namespace Framework\Message\Response;

use Framework\Message\Factory as MessageFactory;
use Framework\Message\Response;
use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;

class HtmlResponse extends Response
{
  public function __construct(int $statusCode, $html)
  {
    parent::__construct($statusCode);

    $this->setBody($this->createBody($html));

    $this->setHeader('Content-Type', 'text/html; charset=utf-8');
  }

  /**
   * Creates the response body from the given HTML data
   */
  private function createBody($html): StreamInterface
  {
    if ($html instanceof StreamInterface) {
      return $html;
    }

    if (is_object($html) && method_exists($html, '__toString')) {
      $html = $html->__toString();
    }

    if (!is_string($html)) {
      throw new InvalidArgumentException('Unable to create HTML response due to unexpected HTML data');
    }

    return (new MessageFactory())->createStream($html);
  }
}