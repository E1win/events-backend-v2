<?php
namespace Framework\Message;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\StreamInterface;

use Framework\Message\Response;
use Framework\Message\Uri;
use Framework\Message\ServerRequest;
use Framework\Message\Stream\FileStream;
use Framework\Message\Stream\InputStream;

class Factory implements ResponseFactoryInterface, ServerRequestFactoryInterface, UriFactoryInterface, StreamFactoryInterface 
{
  public function createResponse(int $code = 200, string $reasonPhrase = ""): ResponseInterface
  {
    return new Response($code, $reasonPhrase);
  }

  public function createUri(string $uri = ''): UriInterface
  {
    return new Uri($uri);
  }

  public function createServerRequest(string $method, $uri, array $serverParams = []): ServerRequestInterface
  {
    return new ServerRequest(
      '1.1',
      $method, 
      $uri,
      $this->createHeaders($serverParams),
      null,
      $serverParams,
    );
  }

  public function createServerRequestFromGlobals(
    array|null $serverParams = null,
    array|null $queryParams = null,
    array|null $cookieParams = null,
    array|null $uploadedFiles = null,
    array|null $parsedBody = null,
  ): ServerRequestInterface {
    $serverParams ??= $_SERVER;
    $queryParams ??= $_GET;
    $cookieParams ??= $_COOKIE;
    $uploadedFiles ??= $_FILES;
    $parsedBody ??= $_POST;

    $body = new InputStream();

    if (!empty($_POST)) {
      $parsedBody = $_POST;
    } else {
      $parsedBody = json_decode($body->getContents(), true);
    }


    // Create functions for stuff like protocol version later.

    return new ServerRequest(
      '1.1',
      strtoupper($serverParams['REQUEST_METHOD']) ?? 'GET',
      $serverParams['REQUEST_URI'] ?? '/',
      $this->createHeaders($serverParams),
      $body,
      $serverParams,
      $queryParams,
      $cookieParams,
      $uploadedFiles,
      $parsedBody,
    );
  }

  public function createStream(string $content = ''): StreamInterface
  {
    $maxmemory = 2097152;
    $mode = 'r+b';
    $stream = new Stream(fopen(sprintf('php://temp/maxmemory:%d', $maxmemory), $mode));

    if (!$content === '') {
      return $stream;
    }

    $stream->write($content);
    $stream->rewind();

    return $stream;
  }

  public function createStreamFromFile(string $filename, string $mode = 'r'): StreamInterface
  {
    return new FileStream($filename, $mode);
  }

  public function createStreamFromResource($resource): StreamInterface
  {
    return new Stream($resource);
  }


  private function createHeaders(array|null $serverParams = null): array {
    $serverParams ??= $_SERVER;

    if (!isset($serverParams['HTTP_CONTENT_LENGTH']) && isset($serverParams['CONTENT_LENGTH'])) {
      $serverParams['HTTP_CONTENT_LENGTH'] = $serverParams['CONTENT_LENGTH'];
    }

    if (!isset($serverParams['HTTP_CONTENT_TYPE']) && isset($serverParams['CONTENT_TYPE'])) {
      $serverParams['HTTP_CONTENT_TYPE'] = $serverParams['CONTENT_TYPE'];
    }

    $headers = [];
    foreach ($_SERVER as $key => $value) {
      if (substr($key, 0, 5) !== 'HTTP_') {
        continue;
      }

      $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
      $headers[$header] = $value;
    }

    return $headers;
  }
}