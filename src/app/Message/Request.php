<?php
namespace App\Message;

use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use App\Message\Message;

use InvalidArgumentException;

class Request extends Message implements RequestInterface {

  public const ALLOWED_HTTP_METHODS = [
    'GET',
    'POST',
    'PUT',
    'PATCH',
    'DELETE',
    'HEAD',
    'OPTIONS',
    'TRACE',
    'CONNECT',
  ];

  private string $method = "GET";
  private UriInterface $uri;
  private string|null $requestTarget = null;

  public function __construct(
    string|null $method = null,
    $uri = null,
    array|null $headers = null,
    StreamInterface $body = null,
  ) {
    if (isset($method)) {
      $this->setMethod($method);
    }

    $this->setUri($uri ?? "/");

    if (isset($headers)) {
      $this->setHeaders($headers);
    }

    if (isset($body)) {
      $this->setBody($body);
    }
  }

  public function getMethod(): string 
  {
    return $this->method;
  }

  public function getUri(): UriInterface 
  {
    return $this->uri;
  }

  public function getRequestTarget(): string
  {
    if (isset($this->requestTarget)) {
      return $this->requestTarget;
    }

    $requestTarget = $this->uri->getPath();

    // https://tools.ietf.org/html/rfc7230#section-5.3.1
    // https://tools.ietf.org/html/rfc7230#section-2.7
    if (strncmp($requestTarget, '/', 1) !== 0) {
      return '/';
    }

    $queryString = $this->uri->getQuery();
    if ($queryString !== '') {
      $requestTarget .= '?' . $queryString;
    }

    return $requestTarget;
  }

  public function withMethod(string $method): RequestInterface
  {
    $clone = clone $this;
    $clone->setMethod($method);

    return $clone;
  }

  public function withUri(UriInterface $uri, bool $preserveHost = false): RequestInterface
  {
    $clone = clone $this;
    $clone->setUri($uri, $preserveHost);

    return $clone;
  }

  public function withRequestTarget(string $requestTarget): RequestInterface
  {
    $clone = clone $this;
    $clone->setRequestTarget($requestTarget);

    return $clone;
  }

  final protected function setMethod($method): void
  {
    $method = strtoupper($method);

    $this->validateMethod($method);

    $this->method = $method;
  }

  final protected function setUri($uri, $preserveHost = false): void
  {
    $this->uri = Uri::create($uri);

    if ($preserveHost && $this->hasHeader('Host')) {
      return;
    }

    $host = $this->uri->getHost();

    if ($host === '') {
      return;
    }

    $port = $this->uri->getPort();
    if (isset($port)) {
      $host .= ':' . $port;
    }

    $this->setHeader('Host', $host, true);
  }

  final protected function setRequestTarget($requestTarget): void
    {
      $this->validateRequestTarget($requestTarget);

      $this->requestTarget = $requestTarget;
    }

  private function validateMethod($method): void
  {
    if ('' === $method) {
      throw new InvalidArgumentException('HTTP method cannot be an empty');
    }

    if (!is_string($method)) {
      throw new InvalidArgumentException('HTTP method must be a string');
    }

    if (!in_array($method, self::ALLOWED_HTTP_METHODS)) {
      throw new InvalidArgumentException('HTTP method must be a valid HTTP method');
    }
  }

  private function validateRequestTarget($requestTarget): void
  {
    if ('' === $requestTarget) {
      throw new InvalidArgumentException('HTTP request target cannot be an empty');
    }

    if (!is_string($requestTarget)) {
      throw new InvalidArgumentException('HTTP request target must be a string');
    }
  }
  
}