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
      // todo: Get better way to add debug information
      // if ($_ENV['APP_DEBUG'] == "true") {
      //   throw $error;
      // }

      return $this->generateResponse($request, $error);
    }
  }

  private function generateResponse(ServerRequestInterface $request, Throwable $error): ResponseInterface
  {
    $statusCode =  $error->getCode() === 0 ? 500 : $error->getCode();

    $response = new Response($statusCode, $error->getMessage());

    return $response;

    // $response = $this->jsonResponseFactory->createJsonResponse([
    //   'error' => $error->getMessage()
    // ], $statusCode);
    
    // $accept = $request->getHeaderLine('Accept');

    
    // if (!array_key_exists($accept, self::CONTENT_TYPE_CONVERSION)) {
    //   return $response;
    // } else {
    //   return $response->withAddedHeader(
    //     'Content-Type',
    //     self::CONTENT_TYPE_CONVERSION[$accept] . '; charset=' . $request->getHeaderLine('Accept-Charset')
    //   );
    // }

  }
}