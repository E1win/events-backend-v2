<?php
namespace Framework\Message;

use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

use InvalidArgumentException;

abstract class Message implements MessageInterface
{
  public const ALLOWED_HTTP_VERSIONS = ['1.0', '1.1', '2.0', '2'];

  public const DEFAULT_HTTP_VERSION = '1.1';

  private string $protocolVersion = self::DEFAULT_HTTP_VERSION;

  private array $headers = [];

  private array $headerNames = [];

  private StreamInterface|null $body = null;

  public function getProtocolVersion(): string
  {
    return $this->protocolVersion;
  }

  
  public function withProtocolVersion(string $version): MessageInterface
  {
    $clone = clone $this;
    $clone->setProtocolVersion($version);
    
    return $clone;
  }

  public function getHeaders(): array
  {
    return $this->headers;
  }

  public function hasHeader(string $name): bool
  {
    return isset($this->headerNames[strtolower($name)]);
  }

  public function getHeader(string $name): array
  {
    $key = strtolower($name);

    if (!isset($this->headerNames[$key])) {
      return [];
    }

    return $this->headers[$this->headerNames[$key]];
  }

  public function getHeaderLine(string $name): string
  {
    $key = strtolower($name);

    if (!isset($this->headerNames[$key])) {
      return '';
    }

    return implode(',', $this->headers[$this->headerNames[$key]]);
  }

  public function withHeader(string $name, $value): MessageInterface
  {
    $clone = clone $this;
    $clone->setHeader($name, $value);

    return $clone;
  }

  public function withAddedHeader(string $name, $value): MessageInterface
  {
    $clone = clone $this;
    $clone->setHeader($name, $value, false);

    return $clone;
  }

  public function withoutHeader(string $name): MessageInterface
  {
    $clone = clone $this;
    $clone->deleteHeader($name);

    return $clone;
  }

  public function getBody(): StreamInterface
  {
    return $this->body ??= (new Factory)->createStream();
  }

  public function withBody(StreamInterface $body): MessageInterface
  {
    $clone = clone $this;
    $clone->setBody($body);

    return $clone;
  }

  
  final protected function setProtocolVersion($version): void
  {
    $this->validateProtocolVersion($version);

    $this->protocolVersion = $version;
  }

  final protected function setHeader($name, $value, $replace = true): void
  {
    $value = is_array($value) ? $value : [$value];

    $this->validateHeaderName($name);
    $this->validateHeaderValue($name, $value);

    if ($replace) {
      $this->deleteHeader($name);
    }

    $key = strtolower($name);

    $this->headerNames[$key] ??= $name;
    $this->headers[$this->headerNames[$key]] ??= [];

    foreach ($value as $item) {
      $this->headers[$this->headerNames[$key]][] = $item;
    }
  }

  final protected function setHeaders(array $headers): void
  {
    foreach ($headers as $name => $value) {
      $this->setHeader($name, $value, false);
    }
  }

  final protected function deleteHeader($name): void
  {
    $key = strtolower($name);

    if (isset($this->headerNames[$key])) {
      unset($this->headers[$this->headerNames[$key]]);
      unset($this->headerNames[$key]);
    }
  }

  final protected function setBody(StreamInterface $body): void
  {
    $this->body = $body;
  }

  private function validateProtocolVersion($version): void
  {
    if (!in_array($version, self::ALLOWED_HTTP_VERSIONS, true)) {
      throw new InvalidArgumentException('Invalid HTTP version');
    }
  }



  private function validateHeaderName($name): void
  {
    if ($name === '') {
      throw new InvalidArgumentException('HTTP header name cannot be an empty');
    }

    if (!is_string($name)) {
      throw new InvalidArgumentException('HTTP header name must be a string');
    }

    // Validate whether name is valid here
  }

  private function validateHeaderValue(string $name, array $value): void
    {
      if ([] === $value) {
        throw new InvalidArgumentException(sprintf(
          'The "%s" HTTP header value cannot be an empty array',
          $name,
        ));
      }

      foreach ($value as $key => $item) {
        if ('' === $item) {
          continue;
        }

        if (!is_string($item)) {
          throw new InvalidArgumentException(sprintf(
            'The "%s[%s]" HTTP header value must be a string',
            $name,
            $key
          ));
        }

        // Validate whether header value is valid here.
      }
    }
}