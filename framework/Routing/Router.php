<?php
namespace Framework\Routing;

use Framework\Middleware\MiddlewareStackInterface;
use Framework\Routing\Contract\RouteInterface;
use Framework\Routing\Contract\RouterInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

// Router can also have child routers
// which are called when route isn't found in current route
// so for example:
// MainRouter has two children WebRouter and ApiRouter
// they both have different middlewares
// and the ones that are the same are in MainRouter
// WebRouter and ApiRouter might have more routers again

// Probably just save routes as array, to avoid having to create an object for each route
// When route is matched and going through all routers
// maybe: keep track of all middleware whilst going through
// and create Route object at end

// https://stackoverflow.com/questions/71458028/how-to-use-a-middleware-for-a-specific-route-among-other-ones

// FOR PATTERN MATCHING:
// https://github.com/thephpleague/route/blob/5.x/src/Router.php

// $router->route('/api', function(router $router) OR MAYBE (new Router) {
//    $router->group(SIMILAR BUT GROUP WITH MIDDLEWARE NO PREFIX)

//    $router->get(blah blah blah);
// })

class Router implements RouterInterface
{
  private $prefix = '';

  /** @var RouteInterface[] */
  private array $routes = [];

  /** @var RouterInterface[] */
  private array $groups = [];

  private MiddlewareStackInterface $middlewareStack;

  protected $patternMatchers = [
    '/{(.+?):number}/'        => '{$1:[0-9]+}',
    '/{(.+?):word}/'          => '{$1:[a-zA-Z]+}',
  ];

  public function match(ServerRequestInterface $request): RouteInterface
  {
    $target = $request->getRequestTarget();

    foreach ($this->groups as $prefix => $router) {
      // Check if request target string starts with prefix
      if (substr($target, 0, strlen($prefix)) === $prefix) {
        // TODO: Maybe add middleware from current router
        // to route here???
        return $router->match($request);
      }
    }

    foreach ($this->routes as $pattern => $route) {
      # code...
    }
  }

  public function group(string $prefix, RouterInterface $router)
  {
    $this->groups[$prefix] = $router->addPrefix($prefix);
  }

  public function get(string $pattern, callable $callback): void
  {
    $this->method('get', $pattern, $callback);
  }

  public function post(string $pattern, callable $callback): void
  {
    $this->method('post', $pattern, $callback);
  }

  public function delete(string $pattern, callable $callback): void
  {
    $this->method('delete', $pattern, $callback);
  }

  public function put(string $pattern, callable $callback): void
  {
    $this->method('put', $pattern, $callback);
  }

  public function method(string $method, string $pattern, callable $callback): void
  {
    // TODO: Check if method is valid

    $this->routes[$pattern] = new Route($method, $this->prefix . $pattern, $callback);
  }

  public function addPrefix(string $prefix): RouterInterface
  {
    $this->prefix .= $prefix;

    return $this;
  }

  public function addMiddleware(MiddlewareInterface $middleware)
  {
    $this->middlewareStack->append($middleware);
  }

  public function addMiddlewares(array $middlewares)
  {
    // . . .
  }

  // PUBLIC JUST TO TEST
  public function parseRoutePath(string $path): string
  {
    return preg_replace(array_keys($this->patternMatchers), array_values($this->patternMatchers), $path);
  }
}