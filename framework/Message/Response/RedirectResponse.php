<?php
namespace Framework\Message\Response;

use Framework\Message\Factory as MessageFactory;
use Framework\Message\Response;
use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;

class RedirectResponse extends Response
{
  protected $targetUrl;

  public function __construct(string $url, int $statusCode = 302, array $headers = [])
  {
    parent::__construct($statusCode, "", $headers);

    $this->setTargetUrl($url);
  }

  public function setTargetUrl(string $url)
  {
    if ('' === $url) {
      throw new \InvalidArgumentException('Cannot redirect to an empty URL.');
    }

    $this->targetUrl = $url;

    $this->setHeader('Location', $this->targetUrl);
  }

  public function getTargetUrl(): string
  {
    return $this->targetUrl;
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