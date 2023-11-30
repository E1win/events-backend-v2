<?php
namespace Framework\Exception;

use Framework\Message\Contract\HtmlResponseFactoryInterface;
use Framework\Message\Contract\JsonResponseFactoryInterface;
use Framework\Message\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

class ExceptionMiddleware implements MiddlewareInterface
{
  private const CONTENT_TYPE_CONVERSION = [
    'application/json' => 'application/problem+json',
    'application/xml' => 'application/problem+xml',
  ];

  public function __construct(
    private JsonResponseFactoryInterface $jsonResponseFactory,
    private HtmlResponseFactoryInterface $htmlResponseFactory,
  ) { }

  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    try {
      return $handler->handle($request);
    } catch (\Throwable $error) {
      return $this->generateResponse($request, $error);
    }
  }

  private function generateResponse(ServerRequestInterface $request, Throwable $error): ResponseInterface
  {
    $statusCode =  $error->getCode() === 0 ? 500 : $error->getCode();

    $body = ['error' => $error->getMessage()];
    
    if ($_ENV['APP_DEBUG'] == "true") {
      $body['trace'] = $error->getTraceAsString();
    }

    return $this->jsonResponseFactory->createJsonResponse($body, $statusCode);
  }
}