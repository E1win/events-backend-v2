<?php
namespace App\Message;

use InvalidArgumentException;
use Psr\Http\Message\UriInterface;

/**
 * Resources:
 * https://developer.mozilla.org/en-US/docs/Learn/Common_questions/Web_mechanics/What_is_a_URL
 */

/** @inheritdoc */
class Uri implements UriInterface
{
  private string $scheme = '';
  private string $userInfo = '';
  private string $host = '';
  private int|null $port = null;
  private string $path = '';
  private string $query = '';
  private string $fragment = '';

  public function __construct(string $uri = '')
  {
    if ($uri === '') {
      return;
    }

    $components = parse_url($uri);

    if ($components === false) {
      throw new InvalidArgumentException('Invalid URI');
    }

    if (isset($components['scheme'])) {
      $this->setScheme($components['scheme']);
    }

    if (isset($components['host'])) {
      $this->setHost($components['host']);
    }

    if (isset($components['port'])) {
      $this->setPort($components['port']);
    }

    if (isset($components['user'])) {
      $this->setUserInfo($components['user']);
    }

    if (isset($components['pass'])) {
      $this->setUserInfo($this->getUserInfo(), $components['pass']);
    }

    if (isset($components['path'])) {
      $this->setPath($components['path']);
    }

    if (isset($components['query'])) {
      $this->setQuery($components['query']);
    }

    if (isset($components['fragment'])) {
      $this->setFragment($components['fragment']);
    }
  }

  public static function create($uri): UriInterface
  {
    if ($uri instanceof UriInterface) {
      return $uri;
    }

    if (!is_string($uri)) {
      throw new InvalidArgumentException("URI should be a string");
    }
    
    return new self($uri);
  }

  public function getScheme(): string
  {
    return $this->scheme;
  }

  public function getAuthority(): string
  {
    $authority = '';

    if ($this->getUserInfo() !== '') {
      $authority .= $this->getUserInfo() . '@';
    }

    $authority .= $this->getHost();

    if ($this->getPort() !== null) {
      $authority .= ':' . $this->getPort();
    }

    return $authority;
  }

  public function getUserInfo(): string
  {
    return $this->userInfo;
  }

  public function getHost(): string
  {
    return $this->host;
  }

  public function getPort(): ?int
  {
    return $this->port;
  }

  public function getPath(): string
  {
    return $this->path;
  }

  public function getQuery(): string
  {
    return $this->query;
  }

  public function getFragment(): string
  {
    return $this->fragment;
  }

  public function withScheme($scheme): UriInterface
  {
    $clone = clone $this;
    $clone->setScheme($scheme);

    return $clone;
  }

  public function withUserInfo($user, $password = null): UriInterface
  {
    $clone = clone $this;
    $clone->setUserInfo($user, $password);

    return $clone;
  }

  public function withHost($host): UriInterface
  {
    $clone = clone $this;
    $clone->setHost($host);

    return $clone;
  }

  public function withPort($port): UriInterface
  {
    $clone = clone $this;
    $clone->setPort($port);

    return $clone;
  }

  public function withPath($path): UriInterface
  {
    $clone = clone $this;
    $clone->setPath($path);

    return $clone;
  }

  public function withQuery($query): UriInterface
  {
    $clone = clone $this;
    $clone->setQuery($query);

    return $clone;
  }

  public function withFragment($fragment): UriInterface
  {
    $clone = clone $this;
    $clone->setFragment($fragment);

    return $clone;
  }

  public function __toString(): string
  {
    $uri = '';

    if ($this->getScheme() !== '') {
      $uri .= $this->getScheme() . ':';
    }

    if ($this->getAuthority() !== '') {
      $uri .= '//' . $this->getAuthority();
    }

    if ($this->getPath() !== '') {
      $uri .= $this->getPath();
    }

    if ($this->getQuery() !== '') {
      $uri .= '?' . $this->getQuery();
    }

    if ($this->getFragment() !== '') {
      $uri .= '#' . $this->getFragment();
    }
    
    return $uri;
  }
  
  final protected function setScheme($scheme): void
  {
    $this->validateScheme($scheme);
    
    $this->scheme = strtolower($scheme);
  }

  final protected function setUserInfo($user, $password = null): void
  {
    $this->validateUserInfo($user, $password);

    $this->userInfo = $user;

    if ($password !== null) {
      $this->userInfo .= ':' . $password;
    }
  }

  final protected function setHost($host): void
  {
    $this->validateHost($host);

    $this->host = strtolower($host);
  }

  final protected function setPort($port): void
  {
    $this->validatePort($port);

    $this->port = $port;
  }

  final protected function setPath($path): void
  {
    $this->validatePath($path);

    $this->path = $path;
  }

  final protected function setQuery($query): void
  {
    $this->validateQuery($query);

    $this->query = $query;
  }

  final protected function setFragment($fragment): void
  {
    $this->validateFragment($fragment);

    $this->fragment = $fragment;
  }


  private function validateFragment($fragment): void
  {
    if ($fragment === '') {
      return;
    }

    if (!is_string($fragment)) {
      throw new InvalidArgumentException('URI component "fragment" must be a string');
    }
  }

  private function validateQuery($query): void
  {
    if ($query === '') {
      return;
    }

    if (!is_string($query)) {
      throw new InvalidArgumentException('URI component "query" must be a string');
    }
  }

  private function validatePath($path): void
  {
    if ($path === '') {
      return;
    }

    if (!is_string($path)) {
      throw new InvalidArgumentException('URI component "path" must be a string');
    }
  }

  private function validatePort($port): void
  {
    if ($port === null) {
      return;
    }

    if (!is_int($port)) {
      throw new InvalidArgumentException('URI component "port" must be an integer');
    }

    if ($port < 1 || $port > 65535) {
      throw new InvalidArgumentException('URI component "port" must be between 1 and 65535');
    }
  }

  private function validateHost($host): void
  {
    if ($host === '') {
      return;
    }

    if (!is_string($host)) {
      throw new InvalidArgumentException('URI component "host" must be a string');
    }
  }

  private function validateUserInfo($user, $password): void
  {
    if ($user === '') {
      return;
    }

    if (!is_string($user)) {
      throw new InvalidArgumentException('URI component "user" must be a string');
    }

    if ($password !== null && !is_string($password)) {
      throw new InvalidArgumentException('URI component "password" must be a string');
    }
  }

  private function validateScheme($scheme): void
  {
    if ($scheme === '') {
      return;
    }

    if (!is_string($scheme)) {
      throw new InvalidArgumentException('URI component "scheme" must be a string');
    }
  }
}
