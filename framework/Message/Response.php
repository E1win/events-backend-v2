<?php
namespace Framework\Message;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

use Framework\Message\Message;
use Framework\Message\Response\JsonResponse;
use InvalidArgumentException;

class Response extends Message implements ResponseInterface
{
  // Maybe refactor this to separate Status enum or class
  public const STATUS_PHRASES = [
    100 => "Continue",
    101 => "Switching Protocols",
    102 => "Processing",
    103 => "Early Hints",

    200 => "OK",
    201 => "Created",
    202 => "Accepted",
    203 => "Non-Authoritative Information",
    204 => "No Content",
    205 => "Reset Content",
    206 => "Partial Content",
    207 => "Multi-Status",
    208 => "Already Reported",
    226 => "IM Used",

    300 => "Multiple Choices",
    301 => "Moved Permanently",
    302 => "Found",
    303 => "See Other",
    304 => "Not Modified",
    305 => "Use Proxy",
    307 => "Temporary Redirect",
    308 => "Permanent Redirect",

    400 => "Bad Request",
    401 => "Unauthorized",
    402 => "Payment Required",
    403 => "Forbidden",
    404 => "Not Found",
    405 => "Method Not Allowed",
    406 => "Not Acceptable",
    407 => "Proxy Authentication Required",
    408 => "Request Timeout",
    409 => "Conflict",
    410 => "Gone",
    411 => "Length Required",
    412 => "Precondition Failed",
    413 => "Payload Too Large",
    414 => "URI Too Long",
    415 => "Unsupported Media Type",
    416 => "Range Not Satisfiable",
    417 => "Expectation Failed",
    418 => "I'm a teapot",
    421 => "Misdirected Request",
    422 => "Unprocessable Entity",
    423 => "Locked",
    424 => "Failed Dependency",
    426 => "Upgrade Required",
    428 => "Precondition Required",
    429 => "Too Many Requests",
    431 => "Request Header Fields Too Large",
    451 => "Unavailable For Legal Reasons",

    500 => "Internal Server Error",
    501 => "Not Implemented",
    502 => "Bad Gateway",
    503 => "Service Unavailable",
    504 => "Gateway Timeout",
    505 => "HTTP Version Not Supported",
    506 => "Variant Also Negotiates",
    507 => "Insufficient Storage",
    508 => "Loop Detected",
    510 => "Not Extended",
    511 => "Network Authentication Required"
  ];

  protected int $statusCode = 200;
  protected string $reasonPhrase = self::STATUS_PHRASES[200];

  static public function json(array $data = [], int $status = 200): ResponseInterface
  {
    // If it's entity,
    // try this...
    // have a toArray() method in them.

    // https://www.php.net/manual/en/function.get-object-vars.php

    return new JsonResponse($status, $data);
  }
  
  public function __construct(
    int|null $statusCode = null, 
    string|null $reasonPhrase = null,
    array|null $headers = null,
    StreamInterface|null $body = null,
  ) {
    if (isset($statusCode)) {
      $this->statusCode = $statusCode;
      $this->setStatus($statusCode, $reasonPhrase ?? '');
    }

    if (isset($headers)) {
      $this->setHeaders($headers);
    }

    if (isset($body)) {
      $this->setBody($body);
    }
  }

  public function getStatusCode(): int
  {
    return $this->statusCode;
  }

  public function getReasonPhrase(): string
  {
    return $this->reasonPhrase;
  }

  public function withStatus(int $code, string $reasonPhrase = ''): ResponseInterface
  {
    $clone = clone $this;
    $clone->setStatus($code, $reasonPhrase);

    return $clone;
  }

  final protected function setStatus(int $code, string $reasonPhrase = ''): void
  {
    $this->validateStatusCode($code);
    $this->validateReasonPhrase($reasonPhrase);

    if ($reasonPhrase === '' && isset(self::STATUS_PHRASES[$code])) {
      $reasonPhrase = self::STATUS_PHRASES[$code];
    }

    // validate status code and reasonphrase
    $this->statusCode = $code;
    $this->reasonPhrase = $reasonPhrase;
  }

  private function validateStatusCode(int $code): void
  {
    if (!is_int($code)) {
      throw new InvalidArgumentException('HTTP status code must be an integer');
    }

    if ($code < 100 || $code > 599) {
      throw new InvalidArgumentException('Invalid HTTP status code');
    }
  }

  private function validateReasonPhrase(string $reasonPhrase): void
  {
    if ($reasonPhrase === '') {
      return;
    }

    if (!is_string($reasonPhrase)) {
      throw new InvalidArgumentException('HTTP reason phrase must be a string');
    }

    if (preg_match('/[^\x09\x0a\x0d\x20-\x7E\x80-\xFE]/', $reasonPhrase)) {
      throw new InvalidArgumentException('HTTP reason phrase must be printable ASCII characters');
    }
  }
}