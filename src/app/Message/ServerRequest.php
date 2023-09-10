<?php
namespace App\Message;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;

use InvalidArgumentException;

/** 
 * Server-side HTTP request.
 * 
 * This class represents a request made to a server and contains information
 * about the request.
 * 
 * This class is immutable; all methods that might change state are implemented
 * 
 * @see https://www.php-fig.org/psr/psr-7/
 */
class ServerRequest extends Request implements ServerRequestInterface
{
  private array $serverParams;
  private array $queryParams;
  private array $cookieParams;
  private array $uploadedFiles = [];
  private $parsedBody = null;
  private array $attributes;

  public function __construct(
    string|null $protocolVersion = null,
    string|null $method = null,
    $uri = null,
    array|null $headers = null,
    StreamInterface|null $body = null,
    array $serverParams = [],
    array $queryParams = [],
    array $cookieParams = [],
    array $uploadedFiles = [],
    $parsedBody = null,
    array $attributes = [],
  ) {
    parent::__construct($method, $uri, $headers, $body);

    if (isset($protocolVersion)) {
      $this->setProtocolVersion($protocolVersion);
    }

    if (!empty($uploadedFiles)) {
      $this->setUploadedFiles($uploadedFiles);
    }

    if (isset($parsedBody)) {
      $this->setParsedBody($parsedBody);
    }

    $this->queryParams = $queryParams;
    $this->serverParams = $serverParams;
    $this->cookieParams = $cookieParams;
    $this->attributes = $attributes;
  }

  public function getServerParams(): array
  {
    return $this->serverParams;
  }

  public function getQueryParams(): array
  {
    return $this->queryParams;
  }

  public function getCookieParams(): array
  {
    return $this->cookieParams;
  }

  public function getUploadedFiles(): array
  {
    return $this->uploadedFiles;
  }

  public function getParsedBody()
  {
    return $this->parsedBody;
  }

  public function getAttributes(): array
  {
    return $this->attributes;
  }

  public function getAttribute(string $name, $default = null)
  {
    return $this->attributes[$name] ?? $default;
  }

  public function withQueryParams(array $query): ServerRequestInterface
  {
    $clone = clone $this;
    $clone->queryParams = $query;

    return $clone;
  }

  public function withCookieParams(array $cookies): ServerRequestInterface
  {
    $clone = clone $this;
    $clone->cookieParams = $cookies;

    return $clone;
  }

  public function withUploadedFiles(array $uploadedFiles): ServerRequestInterface
  {
    $clone = clone $this;
    $clone->setUploadedFiles($uploadedFiles);

    return $clone;
  }

  public function withParsedBody($data): ServerRequestInterface
  {
    $clone = clone $this;
    $clone->setParsedBody($data);

    return $clone;
  }

  public function withAttribute(string $name, $value): ServerRequestInterface
  {
    $clone = clone $this;
    $clone->attributes[$name] = $value;

    return $clone;
  }

  public function withoutAttribute(string $name): ServerRequestInterface
  {
    $clone = clone $this;
    unset($clone->attributes[$name]);

    return $clone;
  }

  final protected function setUploadedFiles(array $uploadedFiles): void
  {
    $this->validateUploadedFiles($uploadedFiles);

    $this->uploadedFiles = $uploadedFiles;
  }

  final protected function setParsedBody($data): void
  {
    $this->validateParsedBody($data);

    $this->parsedBody = $data;
  }

  private function validateUploadedFiles(array $uploadedFiles): void
  {
    if ([] === $uploadedFiles) {
      return;
    }

    foreach ($uploadedFiles as $file) {
      if ($file instanceof UploadedFileInterface) {
        continue;
      }

      if (is_array($file)) {
        $this->validateUploadedFiles($file);
        continue;
      }

      throw new InvalidArgumentException(
        "Uploaded files must be an array of UploadedFileInterface instances"
      );
    }
  }

  private function validateParsedBody($data): void
  {
    if (!is_array($data) && !is_object($data) && !is_null($data)) {
      throw new InvalidArgumentException(
        "Parsed body must be an array, an object or null"
      );
    }
  }
}