<?php
namespace Framework\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CorsMiddleware implements MiddlewareInterface
{
  public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
  {
    $response = $handler->handle($request);

    if (isset($_SERVER['HTTP_ORIGIN'])) {
      // TODO: Decide if origin should be allowed.

      $response = $response
        ->withHeader("Access-Control-Allow-Origin", $_SERVER['HTTP_ORIGIN'])
        ->withHeader("Access-Control-Allow-Credentials", 'true')
        ->withHeader('Access-Control-Max-Age', '86400'); // Cache for 1 day
    }

    if ($request->getMethod() == 'OPTIONS') {
      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
        $response = $response->withHeader('Access-Control-Allow-Methods', "GET, POST, PUT, DELETE, OPTIONS");
      }

      if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
        $response = $response->withHeader('Access-Control-Allow-Headers', $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);
      }

      return $response->withStatus(200);
    }

    return $response;

    // return $handler->handle($request)
    //   // ->withHeader('Access-Control-Allow-Origin', 'http://localhost')
    //   ->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
    //   ->withHeader('Access-Control-Allow-Credentials', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
    //   ->withHeader('Access-Control-Allow-Headers', 'true');
  }
}